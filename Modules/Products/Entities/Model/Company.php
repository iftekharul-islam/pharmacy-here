<?php

namespace Modules\Products\Entities\Model;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'slug', 'status'];
}
