<?php

namespace Modules\Prescription\Entities\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = ['doctor_name', 'prescription_date', 'url', 'user_id'];


}
