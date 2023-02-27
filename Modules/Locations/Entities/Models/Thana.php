<?php

namespace Modules\Locations\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Thana extends Model
{
    protected $fillable = ['name', 'bn_name', 'slug', 'status', 'district_id'];

    protected static function boot() {
        parent::boot();

        static::creating(function ($thana) {
            $thana->slug = Str::slug($thana->name);
        });

        static::updating(function ($thana) {
            $thana->slug = Str::slug($thana->name);
        });
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function areas() {
        return $this->hasMany(Area::class)->orderBy('name', 'ASC');
    }
}
