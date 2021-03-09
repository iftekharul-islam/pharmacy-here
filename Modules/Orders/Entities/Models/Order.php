<?php

namespace Modules\Orders\Entities\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Address\Entities\CustomerAddress;
use Modules\Feedback\Entities\Models\Feedback;
use Modules\Locations\Entities\Models\Address;
use Modules\Prescription\Entities\Models\Prescription;
use Modules\User\Entities\Models\PharmacyBusiness;
use Modules\User\Entities\Models\User;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'phone_number',
        'payment_type',
        'delivery_type',
        'notes',
        'status',
        'amount',
        'delivery_charge',
        'order_date',
        'customer_id',
        'pharmacy_id',
        'shipping_address_id',
        'delivery_method',
        'delivery_date',
        'delivery_time',
        'order_no',
        'subidha_comission',
        'is_rated',
        'pharmacy_amount',
        'customer_amount',
        'point_amount',
        'points',
        'delivery_duration'
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
        return $this->belongsTo(CustomerAddress::class, 'shipping_address_id', 'id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class, 'order_id', 'id');
    }

    public function prescriptions()
    {
//        return $this->hasManyThrough(Prescription::class, OrderPrescription::class, 'order_id', 'id');
        return $this->belongsToMany(Prescription::class, 'order_prescriptions', 'order_id', 'prescription_id');
    }

    public function getDeliveryTimeAttribute($value)
    {
        return Carbon::parse($value)->format('g:i A');
    }

    public function getOrderAmountSum($pharmacy_id)
    {
        return Order::groupBy('pharmacy_id')->selectRaw('SUM(amount) as amount, pharmacy_id');
    }

    public function feedback()
    {
        return $this->belongsTo(Feedback::class, 'id', 'order_id');
    }

    public function cancelReason()
    {
        return $this->belongsTo(OrderCancelReason::class, 'id', 'order_id');
    }

    public function orderHistory()
    {
        return $this->belongsTo(OrderHistory::class, 'id', 'order_id')->orderBy('created_at', 'asc');
    }

    public function pharmacyBusiness()
    {
        return $this->hasOne(PharmacyBusiness::class, 'user_id', 'pharmacy_id');
    }

}

