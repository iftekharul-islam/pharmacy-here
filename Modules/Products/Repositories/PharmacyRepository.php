<?php


namespace Modules\Products\Repositories;


use Dingo\Api\Exception\DeleteResourceFailedException;
// use Modules\Products\Entities\Pharmacy;
use Modules\User\Entities\Models\PharmacyBusiness;
use Modules\User\Entities\Models\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PharmacyRepository
{
    public function all()
    {
        // return User::with('pharmacyBusiness', 'weekends')->where('is_pharmacy', 1)->paginate(10);
        return User::with('pharmacyBusiness', 'weekends')->where('is_pharmacy', 1)->paginate(20);
    }


    public function update($request, $id)
    {
        $pharmacy = PharmacyBusiness::find($id);

        if (!$pharmacy) {
            throw new NotFoundHttpException('Pharmacy not found');
        }

        if (isset($request->name)) {
            $pharmacy->name = $request->name;
        }

        if (isset($request->status)) {
            $pharmacy->status = $request->status;
        }

        $pharmacy->save();
        return $pharmacy;

    }

    /** 
     * Find pharmacy by id
     * @param $id int
    */

    public function findById($id)
    {
        $pharmacy = PharmacyBusiness::with('user', 'weekends')->find($id);

        if (!$pharmacy) {
            throw new NotFoundHttpException('Pharmacy not found');
        }
        return $pharmacy;
    }

    public function delete($id)
    {
        $pharmacy = User::find($id);

        if (! $pharmacy->delete() ) {
            throw new DeleteResourceFailedException('Pharmacy not found');
        }

        return responseData('Pharmacy has been deleted.');
    }

    public function get($id)
    {
        $company =  User::find($id);

        if (! $company) {
            throw new NotFoundHttpException('Pharmacy not found');
        }

        return $company;
    }

}
