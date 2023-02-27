<?php

namespace Modules\Notice\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Models\PharmacyBusiness;
use Modules\User\Entities\Models\User;

class UserNotice extends Model
{
    protected $fillable = ['notice_id', 'pharmacy_id', 'author_id', 'status'];

    public function Pharmacy()
    {
        return $this->belongsTo(PharmacyBusiness::class, 'pharmacy_id', 'id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'pharmacy_id', 'id');
    }
}
