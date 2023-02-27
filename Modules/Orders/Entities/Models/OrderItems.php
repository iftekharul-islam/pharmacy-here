<?php

namespace Modules\Orders\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Products\Entities\Model\Product;

class OrderItems extends Model
{
    protected $fillable = ['quantity', 'rate', 'order_id', 'product_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

//    public function productOrdering()
//    {
//        return $this->belongsTo(Product::class, 'product_id', 'id')->orderByDesc('is_pre_order');
//    }

}
