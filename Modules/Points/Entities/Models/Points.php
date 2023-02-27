<?php

namespace Modules\Points\Entities\Models;

use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
    protected $fillable = ['user_id', 'points', 'type', 'type_id'];
}
