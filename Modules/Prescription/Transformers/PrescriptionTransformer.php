<?php

namespace  Modules\Prescription\Transformers;

use Carbon\Carbon;
use Modules\Products\Entities\Model\Prescripton;
use League\Fractal\TransformerAbstract;
use Modules\Prescription\Entities\Models\Prescription;

class PrescriptionTransformer extends TransformerAbstract
{
    public function transform(Prescription $prescription)
    {

        return [
            'id'                => $prescription->id,
            'patient_name'      => $prescription->patient_name,
            'doctor_name'       => $prescription->doctor_name,
            'prescription_date' => Carbon::parse($prescription->prescription_date)->format('d-m-Y'),
            'url'               => $prescription->url ,
            'user_id'           => $prescription->user_id,

        ];
    }
}
