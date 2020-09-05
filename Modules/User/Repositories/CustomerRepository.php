<?php


namespace Modules\User\Repositories;


use Dingo\Api\Exception\DeleteResourceFailedException;
// use Modules\Products\Entities\Pharmacy;
use Modules\User\Entities\Models\PharmacyBusiness;
use Modules\User\Entities\Models\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomerRepository
{
    public function all()
    {
        return User::where('is_pharmacy', 0)->where('is_admin', 0)->orderby('id', 'desc')->paginate(20);
    }

    public function update($request, $id)
    {

    }

    /**
     * Find pharmacy by id
     * @param $id int
    */

    public function findById($id)
    {

    }

    public function delete($id)
    {
        $data = User::find($id);

        $data->forceDelete();

        return $data;
    }

    public function get($id)
    {
        $data =  User::find($id);

        return $data;
    }

}
