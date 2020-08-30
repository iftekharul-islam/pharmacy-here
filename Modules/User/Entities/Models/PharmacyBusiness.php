<?php

namespace Modules\User\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Locations\Entities\Models\Area;

class PharmacyBusiness extends Model
{
    protected $fillable = [
        'pharmacy_name',
        'pharmacy_address',
        'bank_account_name',
        'bank_account_number',
        'bank_name',
        'bank_brunch_name',
        'bkash_number',
        'start_time',
        "end_time",
        "break_start_time",
        "break_end_time",
        'area_id',
        'bank_routing_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function weekends()
    {
        return $this->hasMany(Weekends::class, 'user_id', 'user_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }
}
