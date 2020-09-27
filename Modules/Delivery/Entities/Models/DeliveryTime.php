<?php

namespace Modules\Delivery\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryTime extends Model
{
    use SoftDeletes;
    protected $fillable = ['start_month', 'end_month', 'start_time', 'end_time', 'delivery_method'];
}
