<?php

namespace Modules\Prescription\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prescription extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['patient_name','doctor_name', 'prescription_date', 'url', 'user_id'];

}
