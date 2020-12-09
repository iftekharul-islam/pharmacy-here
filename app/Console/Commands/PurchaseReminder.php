<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use Modules\Orders\Entities\Models\Order;
use Modules\User\Entities\Models\UserDeviceId;

class PurchaseReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sent:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sent purchase reminder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        logger('In purchase reminder');
        $orders = Order::where('status', 3)->get();

        foreach ($orders as $order) {
            logger('In purchase reminder loop');
//            $orderDate = $order->created_at->addDays(28);
//            $orderDate = $order->created_at->addMinutes(5);
            $value = Carbon::parse($order->created_at)->format('H:i');
//            $values = Carbon::parse($order->created_at)->format('H:i');
            $now = Carbon::now()->subMinute(5)->format('H:i');
            logger('Order details');
            logger($orders);
            logger('Order time');
            logger($value);
            logger('time now sub by 5 min');
            logger($now);
//            if (Carbon::today() == $orderDate ){
            if ( $value >= $now ){
                logger('Notification will sent');

                $deviceIds = UserDeviceId::where('user_id',$order->customer_id)->groupBy('device_id')->get();
                $title = 'Order Reminder';
                $message = 'You can order your medicine from subidha from any where.thanks';

                if (count($deviceIds) < 1) {
                    logger('Device not found');
                }
                foreach ($deviceIds as $deviceId){
                    sendPushNotification($deviceId->device_id, $title, $message, $id="");
                }
            }
            else {
                logger('Notification not sent');
            }

        }
        logger('End purchase reminder');
    }
}
