<?php

namespace Modules\Orders\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Models\PharmacyBusiness;

class OrderHistory extends Model
{
    protected $fillable = ['order_id', 'user_id', 'status'];

    public function pharmacy()
    {
        return $this->belongsTo(PharmacyBusiness::class, 'user_id', 'user_id');
    }

}
