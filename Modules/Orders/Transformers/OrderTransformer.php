<?php


namespace Modules\Orders\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Modules\Address\Transformers\AddressTransformer;
use Modules\Orders\Entities\Models\Order;
use Modules\Prescription\Transformers\PrescriptionTransformer;
use SebastianBergmann\Environment\Console;

class OrderTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'pharmacy', 'address', 'customer', 'orderItems', 'orderPrescriptions', 'prescriptions'
    ];

    public function transform(Order $item)
    {
        return [
            'id'                        => $item->id,
            'phone_number'              => $item->phone_number,
            'customer_name'             => $item->customer->name,
            'customer_phone_number'     => $item->customer->phone_number,
            'pharmacy_id'               => $item->pharmacy_id,
            'amount'                    => $item->amount,
            'point_amount'              => $item->point_amount,
            'points'                    => $item->points,
            'subidha_comission'         => $item->subidha_comission,
            'pharmacy_amount'           => $item->pharmacy_amount,
            'customer_amount'           => $item->customer_amount,
            "shipping_address"          => $item->address,
            "delivery_charge"           => $item->delivery_charge,
            "delivery_type"             => $item->delivery_type,
            "payment_type"              => $item->payment_type,
            "delivery_time"             => $item->delivery_time,
            "status"                    => $item->status,
            "order_date"                => Carbon::parse($item->created_at)->format('d-m-Y'),
            "delivery_method"           => $item->delivery_method,
            "is_rated"                  => $item->is_rated,
            "delivery_date"             => isset($item->delivery_date) ? Carbon::parse($item->delivery_date)->format('d-m-Y') : '',
            "order_no"                  => $item->order_no,
            "updated_at"                => Carbon::parse($item->updated_at)->format('d-m-Y'),
            "delivery_duration"         => $item->delivery_duration,
        ];
    }

    public function includeOrderItems(Order $item)
    {
        return $this->collection($item->orderItems, new OrderItemTransformer());
    }

//    public function includeOrderPrescriptions(Order $item)
//    {
//        return $this->collection($item->orderPrescriptions, new PrescriptionTransformer());
//    }

    public function includePrescriptions(Order $item) {

        return $this->collection($item->prescriptions, new PrescriptionTransformer());
    }

    public function includeAddress(Order $item) {

        return $this->collection($item->address, new AddressTransformer());
    }

}
