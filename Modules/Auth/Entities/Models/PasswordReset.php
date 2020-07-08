<?php

namespace Modules\Auth\Entities\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $fillable = ['email','token'];
}
