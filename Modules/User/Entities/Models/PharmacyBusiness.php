<?php

namespace Modules\User\Entities\Models;

use Illuminate\Database\Eloquent\Model;

class PharmacyBusiness extends Model
{
    protected $fillable = ['pharmacy_name', 'pharmacy_address', 'area_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function weekends()
    {
        return $this->hasMany(Weekends::class, 'user_id', 'user_id');
    }
}
