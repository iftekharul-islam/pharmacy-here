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
        $user = User::find($id);

        if (isset($request->name)) {
            $user->name = $request->name;
        }

        if (isset($request->phone_number)) {
            $user->phone_number = $request->phone_number;
        }

        if (isset($request->alternative_phone_number)) {
            $user->alternative_phone_number = $request->alternative_phone_number;
        }

        if (isset($request->email)) {
            $user->email = $request->email;
        }

        if (isset($request->dob)) {
            $user->dob = $request->dob;
        }

        if (isset($request->gender)) {
            $user->gender = $request->gender;
        }

        if ($request->has('image')) {
            $user->image = $request->get('image');
        }

        $user->save();

        return $user;
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
