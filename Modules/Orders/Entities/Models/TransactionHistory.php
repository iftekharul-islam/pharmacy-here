<?php

namespace Modules\Orders\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Entities\Models\PharmacyBusiness;
use Modules\User\Entities\Models\User;

class TransactionHistory extends Model
{
    protected $table = 'transaction_history';
    protected $fillable = [
        'transaction_id',
        'payment_method',
        'date',
        'pharmacy_id',
    ];

    public function pharmacy()
    {
        return $this->belongsTo(PharmacyBusiness::class, 'pharmacy_id', 'user_id');
    }

//    public function pharmacyAddress()
//    {
//        return $this->belongsTo(PharmacyBusiness::class, 'pharmacy_id', 'id');
//    }



}

