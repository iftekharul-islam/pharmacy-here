<?php

namespace Modules\Orders\Entities\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCancelReason extends Model
{
    protected $table = 'order_cancel_reasons';
    protected $fillable = ['order_id', 'user_id', 'reason'];

}
