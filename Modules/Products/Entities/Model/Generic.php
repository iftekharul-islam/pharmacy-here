<?php

namespace Modules\Products\Entities\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Generic extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'status'];

    protected static function boot() {
        parent::boot();

        static::creating(function ($generic) {
            $generic->slug = Str::slug($generic->name);
        });

        static::updating(function ($generic) {
            $generic->slug = Str::slug($generic->name);
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
