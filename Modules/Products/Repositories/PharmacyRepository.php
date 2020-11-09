<?php


namespace Modules\Products\Repositories;


use Dingo\Api\Exception\DeleteResourceFailedException;
// use Modules\Products\Entities\Pharmacy;
use Modules\User\Entities\Models\PharmacyBusiness;
use Modules\User\Entities\Models\User;
use Modules\User\Entities\Models\UserDeviceId;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PharmacyRepository
{
    public function all()
    {
        return User::with('pharmacyBusiness', 'pharmacyBusiness.area', 'pharmacyBusiness.area.thana', 'pharmacyBusiness.area.thana.district', 'weekends')->where('is_pharmacy', 1)->orderby('id', 'desc')->paginate(20);
        // return PharmacyBusiness::with('user', 'weekends')->paginate(20);
    }

    public function update($request, $id)
    {
        $pharmacy = PharmacyBusiness::find($id);
        $data = $request->only(['pharmacy_name', 'pharmacy_address', 'bank_account_name',
                                'bank_account_number', 'bank_name', 'bank_brunch_name', 'bkash_number',
                                'start_time', 'end_time', 'break_start_time', 'break_end_time']);

        if (!$pharmacy) {
            throw new NotFoundHttpException('Pharmacy not found');
        }
        $pharmacy->update($data);
        $user = User::find($pharmacy->user_id);
        $user->status = $request->status;
        $user->save();
        return $pharmacy;
    }

    /**
     * Find pharmacy by id
     * @param $id int
    */

    public function findById($id)
    {
        // $pharmacy = PharmacyBusiness::with('user', 'weekends')->find($id);
        $pharmacy = PharmacyBusiness::with('user', 'weekends')->where('user_id', $id)->first();
        // $pharmacy = User::with('pharmacyBusiness', 'weekends')->find($id);

        if (!$pharmacy) {
            throw new NotFoundHttpException('Pharmacy not found');
        }
        return $pharmacy;
    }

    public function delete($id)
    {
        $pharmacy = User::find($id);

        $device_id = UserDeviceId::where('user_id', $id)->get();

        if ($device_id != null) {
            foreach ($device_id as $id){
                $id->delete();
            }

        }

        return $pharmacy->forceDelete();

    }

    public function get($id)
    {
        $company =  PharmacyBusiness::find($id);

        if (! $company) {
            throw new NotFoundHttpException('Pharmacy not found');
        }

        return $company;
    }

}
