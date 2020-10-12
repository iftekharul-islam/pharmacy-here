<?php

namespace Modules\Points\Entities\Models;

use Illuminate\Database\Eloquent\Model;

class Refers extends Model
{
    protected $fillable = ['referred_by', 'referred_to'];
}
