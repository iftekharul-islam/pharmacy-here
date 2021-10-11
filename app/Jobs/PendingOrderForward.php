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
        $orders = Order::with('address.area.thana')->where('status', 0)->get();
        $dhaka_district = District::where('slug', 'dhaka')->first();

        logger('order list');
        logger($orders);

        $today = Carbon::today()->format('Y-m-d');
        $todayFixTime = Carbon::now()->format('H:i');
        $morningCheckForRegular = config('subidha.morningTime');
        $eveningCheckForRegular = config('subidha.eveningTime');

        logger('$todayFixTime');
        logger($todayFixTime);
        logger('$morningCheckForRegular');
        logger($morningCheckForRegular);

        foreach ($orders as $order) {
            logger('Order found');

            logger('order id');
            logger($order->order_no);

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
            if ($isPreOrder === true) {
                logger('in the pre order section');
                logger('pre Order End Time');
                $preOrderEndTime = Carbon::parse($order->created_at)->addHour(24);
                logger($preOrderEndTime);

                logger('pre Order Time');
                $preFirstForwardTime = Carbon::now();
                logger($preFirstForwardTime);

                logger('Created at time');
                $preOrderCreated = Carbon::parse($order->created_at);
                logger($preOrderCreated);

                $orphanHour = $preOrderCreated->diff($preOrderEndTime)->format('%H');
                $forwardHour = $preOrderCreated->diff($preFirstForwardTime)->format('%H');
                logger('orphan Hour');
                logger($orphanHour);

                logger('forward Hour');
                logger($forwardHour);

                if ($orphanHour >= 24) {
                    logger('in the pre order 24 hour section');
                    $this->orderMakeOrphan($order);
                    continue;
                }
                if ($forwardHour >= 15) {
                    logger('in the pre order 15 hour section');
                    $this->orderForward($order, $dhaka_district);
                    continue;
                }
                logger('Pre Order status in the same state');
                continue;
            }

            if ($order->delivery_method === 'normal' && $todayFixTime == $morningCheckForRegular) {
                logger('In the regular delivery make orphan on time 9 am based');
                $this->orderMakeOrphan($order);
                continue;
            }
            if ($order->delivery_method === 'normal' && $todayFixTime == $eveningCheckForRegular) {
                logger('In the regular delivery make orphan on time 7 pm based');
                $this->orderMakeOrphan($order);
                continue;
            }

            $expressTime = Carbon::parse($order->delivery_time)->format('H:i');
            logger('$expressTime');
            logger($expressTime);

            $todayTime = Carbon::now()->format('H:i');
            logger('$todayTime');
            logger($todayTime);

            if ($order->delivery_method === 'express' && $order->delivery_date == $today && $todayTime >= $expressTime) {
                logger('In the express delivery orphan on date based');
                $this->orderMakeOrphan($order);
                continue;
            }

            $timeNow = Carbon::now();
            $forwardRegularHour = $order->updated_at->diff($timeNow)->format('%H');
            logger('forward Regular Hour');
            logger($forwardRegularHour);

            if ($order->delivery_date == $today && $forwardRegularHour >= 1) {
                logger('In the forward on regular based');
                $this->orderForward($order, $dhaka_district);
                logger('Order is forwarded');
                continue;
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
            logger('Outside of dhaka');
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

            logger('Order is forwarded');
            return;
        }
        logger('Pre Order status in the same state');
        return;

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
        return;
    }
}
