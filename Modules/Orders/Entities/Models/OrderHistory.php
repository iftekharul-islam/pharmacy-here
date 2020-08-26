<?php

namespace Modules\Orders\Entities\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $fillable = ['order_id', 'user_id', 'status'];

}
