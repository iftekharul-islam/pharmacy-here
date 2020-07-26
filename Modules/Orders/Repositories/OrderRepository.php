<?php


namespace Modules\Orders\Repositories;


use Modules\Orders\Entities\Models\Order;

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
}
