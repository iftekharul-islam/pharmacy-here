<?php

namespace Modules\Products\Entities\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'slug', 'status'];

    protected static function boot() {
        parent::boot();

        static::creating(function ($company) {
            $company->slug = Str::slug($company->name);
        });

        static::updating(function ($company) {
            $company->slug = Str::slug($company->name);
        });
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
