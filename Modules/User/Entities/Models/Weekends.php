<?php

namespace Modules\User\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Weekends extends Model
{
    use SoftDeletes;

    protected $fillable = ['days'];
}
