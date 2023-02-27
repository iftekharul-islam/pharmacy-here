<?php

namespace Modules\Orders\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Prescription\Entities\Models\Prescription;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderPrescription extends Model
{
    use SoftDeletes;

    protected $table="order_prescriptions";

    protected $fillable = ['order_id', 'prescription_id'];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class, 'prescription_id', 'id');
    }
}
