<?php


namespace Modules\User\Repositories;


use Dingo\Api\Exception\DeleteResourceFailedException;
// use Modules\Products\Entities\Pharmacy;
use Illuminate\Support\Facades\DB;
use Modules\Address\Entities\CustomerAddress;
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

        if (!$user) {
            throw new NotFoundHttpException('Customer not found');
        }

        $address = CustomerAddress::where('user_id',$id)->first();

        if (!$address) {
//            throw new NotFoundHttpException('Address not found');
            $address = new CustomerAddress();
        }

        if (isset($request->address)) {
            $address->address = $request->address;
        }

        if (isset($request->area_id)) {
            $address->area_id = $request->area_id;
        }
        logger('Customer update address');

        $address->user_id = $id;
        $address->save();
        logger('Customer update address end');

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
        logger('Customer update ');
        $user->save();
        logger('Customer update end');
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
//        $data = User::find($id);
//        return $data;

        return User::select(
            DB::raw('users.id, users.name, users.phone_number, users.email, users.image,
            users.alternative_phone_number, users.dob, users.gender, users.referral_code, SUM(points.points) as points'))
            ->join('points', 'users.id','=','points.user_id')
            ->where('users.id', $id)->first();
    }

    public function userDetails($id)
    {
        $data =  User::with('customerAddress')->find($id);

        return $data;
    }
    public function userDetailsUpdate($request, $id)
    {
        $user =  User::findOrFail($id);
        $data = $request->only(['name', 'phone_number', 'alternative_phone_number', 'dob', 'gender']);

        if (isset($data['name'])) {
            $user->name = $data['name'];
        }
        if (isset($data['phone_number'])) {
            $user->phone_number = $data['phone_number'];
        }
        if (isset($data['alternative_phone_number'])) {
            $user->alternative_phone_number = $data['alternative_phone_number'];
        }
        if (isset($data['dob'])) {
            $user->dob = $data['dob'];
        }
        if (isset($data['gender'])) {
            $user->gender = $data['gender'];
        }
        $user->save();

        if (isset($request->addressId)){
            $address = CustomerAddress::find($request->addressId);

            if (isset($request->address)) {
                $address->address = $request->address;
            }
            $address->save();
        } else {
            $data = $request->only(['']);
        }
    }

}
