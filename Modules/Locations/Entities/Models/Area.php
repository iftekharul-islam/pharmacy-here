<?php

namespace Modules\Locations\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Area extends Model
{
    protected $fillable = ['name', 'bn_name', 'slug', 'status', 'thana_id'];

    protected static function boot() {
        parent::boot();

        static::creating(function ($division) {
            $division->slug = Str::slug($division->name);
        });

        static::updating(function ($division) {
            $division->slug = Str::slug($division->name);
        });
    }

    public function thana()
    {
        return $this->belongsTo(Thana::class, 'thana_id', 'id');
    }


}
