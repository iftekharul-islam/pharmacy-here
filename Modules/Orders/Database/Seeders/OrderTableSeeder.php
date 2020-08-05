<?php

namespace Modules\Orders\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Orders\Entities\Models\Order;
use Modules\Orders\Entities\Models\OrderItems;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        $order = Order::create([
            'payment_type' => 1,
            'delivery_type' => 1,
            'status' => 1,
            'amount' => 1489,
            'delivery_charge' => 30,
            'order_date' => "2020-07-26",
            'customer_id' => 4,
            'pharmacy_id' => 2,
            'shipping_address_id' => 4
        ]);

        OrderItems::create([
            'quantity' => 12,
            'rate' => 8,
            'order_id' => $order->id,
            'product_id' => 1
        ]);
        OrderItems::create([
            'quantity' => 12,
            'rate' => 8,
            'order_id' => $order->id,
            'product_id' => 2
        ]);

        Order::create([
            'payment_type' => 1,
            'delivery_type' => 1,
            'status' => 1,
            'amount' => 489,
            'delivery_charge' => 20,
            'order_date' => "2020-06-26",
            'customer_id' => 4,
            'pharmacy_id' => 2,
            'shipping_address_id' => 4
        ]);
        Order::create([
            'payment_type' => 1,
            'delivery_type' => 1,
            'status' => 1,
            'amount' => 148,
            'delivery_charge' => 10,
            'order_date' => "2020-07-25",
            'customer_id' => 4,
            'pharmacy_id' => 2,
            'shipping_address_id' => 4
        ]);
    }
}
