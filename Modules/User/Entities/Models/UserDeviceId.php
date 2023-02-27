<?php

namespace Modules\User\Entities\Models;

use Illuminate\Database\Eloquent\Model;

class UserDeviceId extends Model
{
    protected $fillable = [
        'device_id',
        'user_id',
    ];

//    public function user()
//    {
//        return $this->belongsTo(User::class);
//    }
}
