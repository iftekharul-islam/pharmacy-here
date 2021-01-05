<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Modules\Locations\Entities\Models\District;
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
        $orders = Order::with('address.area.thana')->where('status', 0)->where('pharmacy_id', '!=', null)->get();
//        $orders = Order::with('orderItems.product')->where('status', 0)->where('pharmacy_id', '!=', null)->get();
        $dhaka_district = District::where('slug', 'dhaka')->first();

        logger('order list');
        logger($orders);

        foreach ($orders as $order) {

            logger('order');
            logger($order);

            $isPreOrder = false;
            foreach ($order->orderItems as $item) {

                logger('is_pre_order');
                logger($item->product->is_pre_order);

                if ($item->product->is_pre_order == 1) {
                    $isPreOrder = true;
                    logger('pre order true');
                    break;
                }
            }

            $today = Carbon::today()->format('Y-m-d');
            $todayTime = Carbon::now()->format('H:i');
            $orderTime = Carbon::parse($order->delivery_time)->subHour(1)->format('H:i');
            $expressTime = Carbon::parse($order->delivery_time)->format('H:i');
//            $preOrderTime = Carbon::now()->subHour(15)->format('Y-m-d H:i');
            $preOrderTime = Carbon::now()->subMinute(10)->format('Y-m-d H:i');
//            $preOrderEndTime = Carbon::now()->subHour(24)->format('Y-m-d H:i');
            $preOrderEndTime = Carbon::now()->subMinute(15)->format('Y-m-d H:i');

            if ($isPreOrder === true) {
                logger('in the pre order section');

                logger('pre Order End Time');
                logger($preOrderEndTime);
                logger('pre Order Time');
                logger($preOrderTime);
                logger('Created at time');
                logger(Carbon::parse($order->created_at)->format('Y-m-d H:i'));

                if ($preOrderEndTime >= Carbon::parse($order->created_at)->format('Y-m-d H:i')) {
                    logger('in the pre order 24 hour section');
                    $this->orderMakeOrphan($order);
                    return;
                }

//                if ($preOrderTime >= Carbon::parse($order->created_at)->format('Y-m-d h:i') && Carbon::now()->subHour(1)->format('H:i') >= $order->updated_at->format('H:i')) {
                if ($preOrderTime >= Carbon::parse($order->created_at)->format('Y-m-d H:i') && Carbon::now()->subMinute(5)->format('H:i') >= $order->updated_at->format('H:i')) {
                    logger('in the pre order 15 hour section');
                    $this->orderForward($order, $dhaka_district);
                    return;
                }

                logger('Pre Order status in the same state');
                return responseData('Pre Order status in the same state');
            }

            if ($order->delivery_method === 'express' && $order->delivery_date == $today && $todayTime >= $expressTime) {
                logger('In the express delivery orphan on date based');
                $this->orderMakeOrphan($order);
                return;
            }

            if ($order->delivery_date === $today && $todayTime >= $orderTime) {
                logger('In the orphan on date based');
                $this->orderMakeOrphan($order);
                return;
            }

//            if ($order->delivery_date == $today && Carbon::now()->subHour(1)->format('H:i') >= $order->updated_at->format('H:i')) {
            if (Carbon::now()->subMinute(5)->format('H:i') >= $order->updated_at->format('H:i')) {
                logger('In the forward on regular based');
                logger('Order found');
                logger('order id');
                logger($order->id);

                $this->orderForward($order, $dhaka_district);
                return;
            }
        }
        logger('Order Not found to forward');
    }

    /**
     * @param $order
     * @param $dhaka_district
     * @return \Illuminate\Http\JsonResponse
     */
    public function orderForward($order, $dhaka_district)
    {
        $previousPharmacies = OrderHistory::where('order_id', $order->id)->where('status', '!=', 8)->pluck('user_id');
        $previousPharmacies[] = $order->pharmacy_id;

        logger('$previousPharmacies');
        logger($previousPharmacies);

        $nearestPharmacy = PharmacyBusiness::where('area_id', $order->address->area_id)
            ->whereHas('user', function ($q) {
                $q->where('status', 1);
            })->whereNotIn('user_id', $previousPharmacies)->inRandomOrder()->first();

        if (!$nearestPharmacy && $dhaka_district->id != $order->address->area->thana->district_id) {
            $nearestPharmacy = PharmacyBusiness::whereHas('area', function ($q) use ($order) {
                $q->where('thana_id', $order->address->area->thana_id);
            })->whereHas('user', function ($q) {
                $q->where('status', 1);
            })->whereNotIn('user_id', $previousPharmacies)->inRandomOrder()->first();
        }

        if ($nearestPharmacy != null) {

            $orderHistory = new OrderHistory();
            $orderHistory->order_id = $order->id;
            $orderHistory->user_id = $nearestPharmacy->user_id;
            $orderHistory->status = 6;
            $orderHistory->save();

            $order->pharmacy_id = $nearestPharmacy->user_id;
            $order->save();

            $deviceIds = UserDeviceId::where('user_id', $order->pharmacy_id)->groupBy('device_id')->get();
            $title = 'New Order Available';
            $message = 'You have a new order from Subidha. Please check.';

            foreach ($deviceIds as $deviceId) {
                sendPushNotification($deviceId->device_id, $title, $message, $id = "");
            }

            return responseData('Order status updated');
        }
        logger('Pre Order status in the same state');
        return responseData('Pre Order status in the same state');

    }

    /**
     * @param $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function orderMakeOrphan($order)
    {
        $subject = 'An order ID: ' . $order->order_no . ' has been Orphaned';
        SendNotificationToAdmin::dispatch($order, $subject, $isCancel = false);

        $orderHistory = new OrderHistory();
        $orderHistory->order_id = $order->id;
        $orderHistory->user_id = $order->pharmacy_id;
        $orderHistory->status = 8;
        $orderHistory->save();

        $order->pharmacy_id = null;
        $order->status = 8;
        $order->save();

        logger('Order is Orphaned');
        return responseData('Order is Orphaned');
    }
}
