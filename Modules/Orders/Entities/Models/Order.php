<?php

namespace Modules\Orders\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Locations\Entities\Models\Address;
use Modules\User\Entities\Models\User;

class Order extends Model
{
    protected $fillable = [
        'payment_type',
        'delivery_type',
        'status',
        'amount',
        'delivery_charge',
        'order_date',
        'customer_id',
        'pharmacy_id',
        'shipping_address_id'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function pharmacy()
    {
        return $this->belongsTo(User::class, 'pharmacy_id', 'id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id', 'id');
    }

}

