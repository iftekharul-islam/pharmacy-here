<?php

namespace Modules\Resources\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model
{
    use SoftDeletes;
    protected $fillable = ['title','bn_title', 'description','bn_description', 'url'];
}
