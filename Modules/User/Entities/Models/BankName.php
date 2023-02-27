<?php

namespace Modules\User\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankName extends Model
{
    use SoftDeletes;

    protected $fillable = ['bank_name', 'bn_bank_name', 'status'];
}
