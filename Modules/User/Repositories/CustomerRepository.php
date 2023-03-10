<?php


namespace Modules\User\Repositories;


use Dingo\Api\Exception\DeleteResourceFailedException;
// use Modules\Products\Entities\Pharmacy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Address\Entities\CustomerAddress;
use Modules\User\Entities\Models\PharmacyBusiness;
use Modules\User\Entities\Models\User;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;

class CustomerRepository
{
    public function all($request)
    {
        $data = User::query();

        if ($request->search !== null) {
            $data->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->search}%")
                    ->orWhere('phone_number', 'LIKE', "%{$request->search}%")
                    ->orWhere('email', 'LIKE', "%{$request->search}%");
            });
        }
        $data->where('is_pharmacy', '!=', 1)->where('is_admin', 0);

        return $data->orderby('id', 'desc')->paginate(20);
    }

    public function create($request)
    {
        $data = $request->only(['name', 'email', 'phone_number', 'status']);
        $user = User::create($data);

        $role = Role::where('name', 'customer')->first();
        if ($user && $role) {
            $user->assignRole($role);
        }

        return $user;
    }

    public function UpdateWeb($request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return false;
        }
        $data = $request->only(['name', 'email', 'phone_number', 'password', 'status']);

        if (isset($request->name)) {
            $user->name = $request->name;
        }

        if (isset($data['email'])) {
            $user->email = $data['email'];
        }

        if (isset($data['phone_number'])) {
            $user->phone_number = $data['phone_number'];
        }
        if (isset($data['phone_number'])) {
            $user->phone_number = $data['phone_number'];
        }
        if (isset($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        if (isset($data['status'])) {
            $user->status = $data['status'];
        }
        $user->save();

        return true;
    }


    public function update($request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            throw new NotFoundHttpException('Customer not found');
        }

        $address = CustomerAddress::where('user_id', $id)->first();

        if (!$address) {
            $address = new CustomerAddress();
        }

        if (isset($request->address)) {
            $address->address = $request->address;
        }

        if (isset($request->area_id)) {
            $address->area_id = $request->area_id;
        }

        $address->user_id = $id;
        $address->save();

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
        return User::find($id);
    }

    public function delete($id)
    {
        $data = User::find($id);

        $data->forceDelete();

        return $data;
    }

    public function get($id)
    {
        return User::select(
            DB::raw('users.id, users.name, users.phone_number, users.email, users.image,
            users.alternative_phone_number, users.dob, users.gender, users.referral_code, SUM(points.points) as points'))
            ->join('points', 'users.id', '=', 'points.user_id')
            ->where('users.id', $id)->first();
    }

    /**
     * @param $request
     * @param $id
     */
    public function userDetailsUpdate($request, $id)
    {
        $user = User::findOrFail($id);
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
    }

}
