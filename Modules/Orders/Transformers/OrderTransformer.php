<?php


namespace Modules\Orders\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Modules\Orders\Entities\Models\Order;
use Modules\User\Transformers\PharmacyTransformer;

class OrderTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'pharmacy', 'address', 'customer', 'orderItems', 'orderPrescriptions'
    ];

    public function transform(Order $item)
    {
        // $delivery_time = Carbon::parse($item->delivery_time)->format('g:i A');
        return [
            'id'                        => $item->id,
            'customer_name'             => $item->customer->name,
            'amount'                    => $item->amount,
            "shipping_address"          => $item->address,
            "delivery_charge"           => $item->delivery_charge,
            "delivery_type"             => $item->delivery_type,
            "payment_type"              => $item->payment_type,
            "delivery_time"             => $item->delivery_time,
            "status"                    => $item->status,
            "order_date"                => $item->created_at,
        ];
    }

    public function includeOrderItems(Order $item)
    {
        return $this->collection($item->orderItems, new OrderItemTransformer());
    }

    public function includeOrderPrescriptions(Order $item)
    {
        return $this->collection($item->orderPrescriptions, new OrderPrescriptionTransformer());
    }
   
}
