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
        $orders = Order::where('status', 3)->get();

        foreach ($orders as $order) {
            $orderDate = $order->created_at->addDays(28);
            if (Carbon::today() == $orderDate ){
                logger('Notification will sent');

                $deviceIds = UserDeviceId::where('user_id',$order->customer_id)->get();
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
    }
}
