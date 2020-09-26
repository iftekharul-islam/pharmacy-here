<?php

namespace Modules\Delivery\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryTime extends Model
{
    use SoftDeletes;
    protected $fillable = [];
}
