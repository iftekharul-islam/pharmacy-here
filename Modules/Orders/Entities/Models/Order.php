<?php

namespace Modules\Orders\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Locations\Entities\Models\Address;
use Modules\Prescription\Entities\Models\Prescription;
use Modules\User\Entities\Models\User;

class Order extends Model
{
    use SoftDeletes;

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

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class, 'order_id', 'id');
    }

    public function prescriptoins()
    {
        return $this->hasMany(OrderPrescription::class);
    }

}

