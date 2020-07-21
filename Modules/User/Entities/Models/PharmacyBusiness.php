<?php

namespace Modules\User\Entities\Models;

use Illuminate\Database\Eloquent\Model;

class PharmacyBusiness extends Model
{
    protected $fillable = ['pharmacy_name', 'pharmacy_address', 'bank_account', 'bkash'];
}
