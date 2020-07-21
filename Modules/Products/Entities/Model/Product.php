<?php

namespace Modules\Products\Entities\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'status',
        'trading_price',
        'purchase_price',
        'unit',
        'is_saleable',
        'conversion_factor',
        'type',
        'form_id',
        'category_id',
        'generic_id',
        'manufacturing_company_id',
        'primary_unit_id',
    ];

    protected static function boot() {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });

        static::updating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }

    public function productAdditionalInfo()
    {
        return $this->hasOne(ProductAdditionalInfo::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'manufacturing_company_id', 'id');
    }

    public function generic()
    {
        return $this->belongsTo(Generic::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function primaryUnit()
    {
        return $this->belongsTo(Unit::class, 'primary_unit_id', 'id');
    }

}
