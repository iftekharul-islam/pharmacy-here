<?php

namespace Modules\User\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PharmacyBusiness extends Model
{
    protected $fillable = ['pharmacy_name', 'pharmacy_address', 'area_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
