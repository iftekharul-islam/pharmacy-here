<?php

namespace Modules\Locations\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class District extends Model
{
    protected $fillable = ['name', 'bn_name', 'slug', 'status', 'division_id'];

    protected static function boot() {
        parent::boot();

        static::creating(function ($district) {
            $district->slug = Str::slug($district->name);
        });

        static::updating(function ($district) {
            $district->slug = Str::slug($district->name);
        });
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    public function thanas() {
        return $this->hasMany(Thana::class );
    }
}
