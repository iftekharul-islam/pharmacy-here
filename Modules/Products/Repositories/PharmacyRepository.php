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
    public function all($request)
    {
        $district_id = $request->district_id;
        $thana_id = $request->thana_id;
        $area_id = $request->area_id;
        $data = User::query();

        $data->with('pharmacyBusiness', 'pharmacyBusiness.area', 'pharmacyBusiness.area.thana', 'pharmacyBusiness.area.thana.district', 'weekends')
            ->where('is_pharmacy', 1)
            ->orderby('id', 'desc');

        if ($request->search !== null){
            $data->whereHas('pharmacyBusiness', function ($query) use ($request) {
                $query->where('pharmacy_name', 'LIKE', "%{$request->search}%") ;
            });
        }
        if ($area_id !== null) {
            $data->whereHas('pharmacyBusiness', function ($query) use ($area_id) {
                $query->where('area_id', $area_id);
            });
        }
        if ($thana_id !== null && $area_id == null) {
            $data->whereHas('pharmacyBusiness.area', function ($query) use ($thana_id) {
                $query->where('thana_id', $thana_id);
            });
        }
        if ($district_id !== null && $thana_id == null && $area_id == null) {
            $data->whereHas('pharmacyBusiness.area.thana', function ($query) use ($district_id) {
                $query->where('district_id', $district_id);
            });
        }

        return $data->paginate(config('subidha.item_per_page'));
    }

    public function search($request)
    {
        return User::with('pharmacyBusiness', 'pharmacyBusiness.area', 'pharmacyBusiness.area.thana', 'pharmacyBusiness.area.thana.district', 'weekends')
            ->where('is_pharmacy', 1)
            ->whereHas('pharmacyBusiness', function ($query) use ($request) {
                $query->where('pharmacy_name', 'LIKE', "%{$request->search}%") ;
            })
            ->paginate(config('subidha.item_per_page'));
    }

    public function update($request, $id)
    {
        $pharmacy = PharmacyBusiness::where('user_id', $id)->first();
        $data = $request->only(['pharmacy_name', 'area_id', 'pharmacy_address', 'bank_account_name',
                                'bank_account_number', 'bank_name', 'bank_brunch_name', 'bank_routing_number',
                                'start_time', 'end_time', 'break_start_time', 'break_end_time']);

        if (!$pharmacy) {

            $pharmacyBusiness = new PharmacyBusiness();

            if (isset($request->pharmacy_name)) {
                $pharmacyBusiness->pharmacy_name = $request->pharmacy_name;
            }

            if (isset($request->area_id)) {
                $pharmacyBusiness->area_id = $request->area_id;
            }

            if (isset($request->pharmacy_address)) {
                $pharmacyBusiness->pharmacy_address = $request->pharmacy_address;
            }

            if (isset($request->bank_account_name)) {
                $pharmacyBusiness->bank_account_name = $request->bank_account_name;
            }

            if (isset($request->bank_account_number)) {
                $pharmacyBusiness->bank_account_number = $request->bank_account_number;
            }

            if (isset($request->bank_name)) {
                $pharmacyBusiness->bank_name = $request->bank_name;
            }

            if (isset($request->bank_brunch_name)) {
                $pharmacyBusiness->bank_brunch_name = $request->bank_brunch_name;
            }

            if (isset($request->bank_routing_number)) {
                $pharmacyBusiness->bank_routing_number = $request->bank_routing_number;
            }
            if (isset($request->start_time)) {
                $pharmacyBusiness->start_time = $request->start_time;
            }

            if (isset($request->end_time)) {
                $pharmacyBusiness->end_time = $request->end_time;
            }

            if (isset($request->break_start_time)) {
                $pharmacyBusiness->break_start_time = $request->break_start_time;
            }

            if (isset($request->break_end_time)) {
                $pharmacyBusiness->break_end_time = $request->break_end_time;
            }

            $pharmacyBusiness->user_id = $id;

            $pharmacyBusiness->save();

            $user = User::find($id);
            $user->status = $request->status;
            $user->save();
            return $pharmacyBusiness;
        }

        $pharmacy->update($data);
        $user = User::find($id);
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
//        $pharmacy = PharmacyBusiness::with('user', 'weekends')->where('user_id', $id)->first();
        $pharmacy = User::with('PharmacyBusiness', 'PharmacyBusiness.weekends', 'PharmacyBusiness.area', 'PharmacyBusiness.area.thana', 'PharmacyBusiness.area.thana.district')->find($id);

        // $pharmacy = User::with('pharmacyBusiness', 'weekends')->find($id);

        if (!$pharmacy) {
            $user = User::find($id);
            return $user;
//            throw new NotFoundHttpException('Pharmacy not found');
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
