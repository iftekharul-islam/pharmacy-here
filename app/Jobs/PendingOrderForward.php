<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Orders\Entities\Models\Order;
use Modules\Orders\Entities\Models\OrderHistory;
use Modules\User\Entities\Models\PharmacyBusiness;
use Modules\User\Entities\Models\UserDeviceId;
use Modules\User\Entities\Models\Weekends;

class PendingOrderForward implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        logger('in the forward job');
        $orders = Order::with('address')->whereIn('status', [0, 5, 6])->where('pharmacy_id', '!=', null)->get();
        logger('order list');
        logger($orders);
        foreach ($orders as $order) {
            logger('Order time');
            logger($order->updated_at->format('H:i'));
            logger('Checking Time');
            logger(Carbon::now()->subMinute(5)->format('H:i'));

//            if (Carbon::now()->subMinute(5)->format('H:i') >= $order->updated_at->format('H:i')) {
            if ($order->created_at->format('H:i') >= Carbon::now()->subMinute(5)->format('H:i')) {

                logger('Order found');
                logger('order id');
                logger($order->id);

                $previousPharmacies = OrderHistory::where('order_id', $order->id)->where('status', '!=', 8)->pluck('user_id');
                $previousPharmacies[] = $order->pharmacy_id;

                logger('$previousPharmacies');
                logger($previousPharmacies);

                $date = Carbon::today()->format('l');
                $Holiday = strtolower($date);
                $time = Carbon::now()->format('H:i:s');
//                $isAvailable = Weekends::where('days', $Holiday)->groupBy('user_id')->pluck('user_id');
                $previousPharmacies[] = Weekends::where('days', $Holiday)->groupBy('user_id')->pluck('user_id');
                $nearestPharmacy = PharmacyBusiness::where('area_id', $order->address->area_id)
//                    ->whereNotIn('user_id', $isAvailable)
                    ->whereNotIn('user_id', $previousPharmacies)
                    ->where(function ($query) use ($time) {
                        $query->Where('is_full_open', 1)
                            ->orWhere(function ($q) use ($time) {
                                $q->where(function ($q) use ($time) {
                                    $q->where('start_time', '<', $time)
                                        ->Where('end_time', '>', $time);
                                });
//                            ->Where(function ($q) use ($time) {
//                                $q->Where('break_start_time', '>', $time)
//                                    ->orWhere('break_end_time', '<', $time);
//                            });
                            });

                    })->whereHas('user', function ($q) {
                        $q->where('status', 1);
                    })->inRandomOrder()->first();

                if ($nearestPharmacy != null) {

                    logger("nearest Pharmacy found");
                    logger($nearestPharmacy->pharmacy_name);

                    $orderHistory = new OrderHistory();
                    $orderHistory->order_id = $order->id;
                    $orderHistory->user_id = $nearestPharmacy->user_id;
                    $orderHistory->status = 6;
                    $orderHistory->save();

                    $order->pharmacy_id = $nearestPharmacy->user_id;
                    $order->save();

                    $deviceIds = UserDeviceId::where('user_id', $order->pharmacy_id)->get();
                    $title = 'New Order Available';
                    $message = 'You have a new order from Subidha. Please check.';

                    foreach ($deviceIds as $deviceId) {
                        sendPushNotification($deviceId->device_id, $title, $message, $id = "");
                    }

                    return responseData('Order status updated');
                }
                logger("nearest Pharmacy not found");

                $subject = 'An order ID: ' . $order->order_no . ' has been Orphaned';
                SendNotificationToAdmin::dispatch($order, $subject, $isCancel = false);
                $order->pharmacy_id = null;
                $order->status = 8;
                $order->save();

                $orderHistory = new OrderHistory();
                $orderHistory->order_id = $order->id;
                $orderHistory->user_id = 0;
                $orderHistory->status = 8;
                $orderHistory->save();

                logger('Order is Orphaned');
                return responseData('Order is Orphaned');
            }
        }
        logger('Order Not found to forward');
    }
}
