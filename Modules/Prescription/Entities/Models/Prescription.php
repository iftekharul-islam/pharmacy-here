<?php

namespace Modules\Prescription\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Orders\Entities\Models\OrderPrescription;

class Prescription extends Model
{
    use SoftDeletes;

    protected $table = 'prescriptions';

    protected $fillable = ['patient_name','doctor_name', 'prescription_date', 'url', 'user_id'];

//    public function orderPrescriptions()
//    {
//        return $this->hasOne(OrderPrescription::class);
//    }

}
