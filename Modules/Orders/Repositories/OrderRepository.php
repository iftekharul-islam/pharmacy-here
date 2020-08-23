<?php


namespace Modules\Orders\Repositories;

use Carbon\Carbon;
use Modules\Orders\Entities\Models\Order;
use Modules\Orders\Entities\Models\OrderItems;
use Modules\Orders\Entities\Models\OrderPrescription;

class OrderRepository
{
    /**
     * @param $pharmacy_id
     * @return mixed
     */
    public function byPharmacyId($pharmacy_id)
    {
        return Order::where('pharmacy_id', $pharmacy_id)->get();
    }

    /**
     * @param $customer_id
     * @return mixed
     */
    public function byCustomerId($customer_id)
    {
        return Order::where('customer_id', $customer_id)->get();
    }

    public function get($id)
    {
        return Order::where('id', $id)->first();
    }


    public function create($request, $id)
    {
        $order = new Order();
        $order->phone_number = $request->get('phone_number');
        $order->payment_type = $request->get('payment_type');
        $order->delivery_type = $request->get('delivery_type');
        $order->status = $request->get('status');
        $order->delivery_charge = $request->get('delivery_charge');
        $order->amount = $request->get('amount');
        $order->order_date = Carbon::now()->format('Y-m-d');
        $order->delivery_time =$request->get('delivery_time');
        $order->notes =$request->get('notes');
        $order->customer_id = $id;
        $order->pharmacy_id = $request->get('pharmacy_id');
        $order->shipping_address_id =$request->get('shipping_address_id');
        
        $order->save();

        if ( $request->order_items ) {
            // $order->orderItems()->saveMany($request->order_items);
            $this->storeAssociateProducts($request->order_items, $order->id);
        }

        if ( $request->prescriptions ) {
            $this->storeAssociatePrescriptions($request->prescriptions, $order->id);
        }

        return $order;
    }

    public function storeAssociateProducts($items, $order_id) 
    {
        if (is_array($items) && count($items) > 0 ) {
            foreach($items as $item) {
                OrderItems::create([
                    'product_id' => $item['product_id'],
                    'rate' => $item['rate'],
                    'quantity' => $item['quantity'],
                    'order_id' => $order_id,
                ]);
            }
        }
    }

    public function storeAssociatePrescriptions($items, $order_id) 
    {
        if (is_array($items) && count($items) > 0 ) {
            foreach($items as $item) {
                OrderPrescription::create([
                    'prescription_id' => $item,
                    'order_id' => $order_id,
                ]);
            }
        }
    }
}
