<?php

namespace Modules\Notice\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{
    use SoftDeletes;
    protected $table = 'notice_board';
    protected $fillable = ['notice', 'bn_notice', 'status', 'type'];
}
