<?php

namespace Modules\Products\Entities\Model;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{

    protected $fillable = ['product_id', 'quantity', 'amount'];

//    protected static function boot() {
//        parent::boot();
//
//        static::creating(function ($company) {
//            $company->slug = Str::slug($company->name);
//        });
//
//        static::updating(function ($company) {
//            $company->slug = Str::slug($company->name);
//        });
//    }
//
//    public function cart()
//    {
//        return $this->hasMany(Cart::class, 'cart_id', 'id');
//    }

    public function product()
    {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }
}
