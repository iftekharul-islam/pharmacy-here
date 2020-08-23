<?php


namespace Modules\Prescription\Repositories;

use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Support\Str;
use Modules\Prescription\Entities\Models\Prescription;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PrescriptionRepository
{
    public function all()
    {
        // return Unit::get();
    }

    public function getCustomerPrescription($id)
    {
        $prescription = Prescription::where('user_id', $id)->get();
        return $prescription;
    }

    public function findById($id)
    {
        $Prescription = Prescription::find($id);

        return $Prescription;
    }

    public function create($data, $user_id)
    {
        return Prescription::create([
            'doctor_name' => $data->get('doctor_name'),
            'prescription_date' => $data->get('prescription_date'),
            'url' => $data->get('url'),
            'user_id' => $user_id
        ]);

    }

    public function findBySlug($slug)
    {
        //$unit = Unit::where('slug', $slug)->first();

        return $slug;
    }

    public function update($request, $id)
    {
        $prescription = Prescription::find($id);

        if (!$prescription) {
            throw new NotFoundHttpException('Prescription not found');
        }

        if (isset($request->doctor_name)) {
            $prescription->doctor_name = $request->doctor_name;
        }

        if (isset($request->prescription_date)) {
            $prescription->prescription_date = $request->prescription_date;
        }

        if (isset($request->url)) {
            $prescription->url = $request->url;
        }

        $prescription->save();

        return $prescription;

    }

    public function delete($id)
    {
        $prescription = Prescription::find($id);

        if (! $prescription) {
            throw new NotFoundHttpException('Prescripiton not found');
        }

        return $prescription->delete();
    }

}
