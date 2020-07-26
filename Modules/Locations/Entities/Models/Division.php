<?php

namespace Modules\Locations\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Division extends Model
{
    protected $fillable = ['name', 'bn_name', 'slug', 'status'];

    protected static function boot() {
        parent::boot();

        static::creating(function ($division) {
            $division->slug = Str::slug($division->name);
        });

        static::updating(function ($division) {
            $division->slug = Str::slug($division->name);
        });
    }


}
