<?php

namespace Modules\Orders\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Products\Entities\Model\Product;
use Modules\User\Entities\Models\User;

class Cart extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'amount',
        'quantity',
        'customer_id',
        'product_id'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}

