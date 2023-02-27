<?php

namespace Modules\Products\Entities\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\User\Entities\Models\User;

class Cart extends Model
{
    use SoftDeletes;

    protected $fillable = ['customer_id', 'order_from'];

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
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }


}
