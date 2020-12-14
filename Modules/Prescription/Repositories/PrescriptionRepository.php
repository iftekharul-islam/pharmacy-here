<?php


namespace Modules\Prescription\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Points\Entities\Models\Points;
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
        $prescription = Prescription::where('user_id', $id)->orderBy('created_at', 'desc')->get();;
        return $prescription;
    }

    public function getCustomerPrescriptionWeb($id)
    {
        $prescription = Prescription::where('user_id', $id)->orderBy('created_at', 'desc')->paginate(6);
        return $prescription;
    }

    public function findById($id)
    {
        $Prescription = Prescription::find($id);

        return $Prescription;
    }

    public function create($data, $user_id)
    {
        $isFirstUpload = Prescription::where('user_id', $user_id)->first();

        $prescription = Prescription::create([
            'patient_name' => $data->get('patient_name'),
            'doctor_name' => $data->get('doctor_name'),
            'prescription_date' => $data->get('prescription_date'),
            'url' => $data->get('url'),
            'user_id' => $user_id
        ]);

        logger('Prescription create');
        logger($prescription);
        logger('Prescription create end');


        logger('$isFirstUpload ');
        logger($isFirstUpload);

        logger(config('subidha.point_on_first_use'));
        logger('$isFirstUpload end');

        if (!$isFirstUpload) {
            Points::create([
                'user_id' => $user_id,
                'points' => config('subidha.point_on_first_use'),

                'type' => 'prescription',
                'type_id' => $prescription->id,
            ]);
        }

        return $prescription;

    }

    public function createWeb($request)
    {
        $data = $request->only(['patient_name', 'doctor_name', 'prescription_date', 'url', 'user_id']);
        $data['user_id'] = Auth::user()->id;
        $data['patient_name'] = $data['patient_name'] ? $data['patient_name'] : Auth::user()->name;

        $image = $request->file('url');
        $link = Storage::disk('gcs');
        $disk = $link->put('images/customer/prescription', $image);
        $data['url'] = $link->url($disk);

        return Prescription::create($data);
    }

    public function findBySlug($slug)
    {
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

        if (!$prescription) {
            throw new NotFoundHttpException('Prescripiton not found');
        }

        return $prescription->delete();
    }

}
