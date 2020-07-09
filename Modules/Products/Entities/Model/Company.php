<?php

namespace Modules\Products\Entities\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'slug', 'status'];
}
