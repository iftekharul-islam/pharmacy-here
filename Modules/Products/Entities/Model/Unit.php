<?php

namespace Modules\Products\Entities\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Unit extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'slug', 'status'];

    protected static function boot() {
        parent::boot();

        static::creating(function ($unit) {
            $unit->slug = Str::slug($unit->name);
        });

        static::updating(function ($unit) {
            $unit->slug = Str::slug($unit->name);
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
