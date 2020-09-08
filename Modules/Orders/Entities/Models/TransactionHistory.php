<?php

namespace Modules\Orders\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
        return $this->belongsTo(User::class, 'pharmacy_id', 'id');
    }



}

