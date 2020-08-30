<?php


namespace Modules\User\Repositories;


use Modules\User\Entities\Models\PharmacyBusiness;
use Modules\User\Entities\Models\User;
use Modules\User\Entities\Models\Weekends;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PharmacyRepository
{
    public function createBusinessInfo($request, $id)
    {
        $pharmacyBusiness = new PharmacyBusiness();

        if ($request->has('nid_image')) {
            $pharmacyBusiness->nid_img_path = $request->get('nid_image');
        }

        if ($request->has('trade_licence')) {
            $pharmacyBusiness->trade_img_path = $request->get('trade_licence');
        }

        if ($request->has('drug_licence')) {
            $pharmacyBusiness->drug_img_path = $request->get('drug_licence');
        }

        if (isset($request->area_id)) {
            $pharmacyBusiness->area_id = $request->area_id;
        }

        if (isset($request->pharmacy_address)) {
            $pharmacyBusiness->pharmacy_address = $request->pharmacy_address;
        }

        if (isset($request->pharmacy_name)) {
            $pharmacyBusiness->pharmacy_name = $request->pharmacy_name;
        }

        $pharmacyBusiness->user_id = $id;

        $pharmacyBusiness->save();

        return $pharmacyBusiness;


    }

    public function getWeekendsAndWorkingHoursInfo($id)
    {
        return Weekends::where('user_id', $id)->get();
    }

    public function createWeekendsAndWorkingHoursInfo($request, $id)
    {
        $user = User::find($id);

        if (! $user) {
            throw new NotFoundHttpException('Pharmacy Not Found');
        }


        $weekends = $request->weekends;

        foreach ($weekends as $weekend) {
            $weekendDays = new Weekends();
            $weekendDays->user_id = $id;
            $weekendDays->days = $weekend;

            $weekendDays->save();
        }


        $pharmacyInfo = PharmacyBusiness::where('user_id', $id)->first();

        if (isset($request->start_time)) {
            $pharmacyInfo->start_time = $request->start_time;
        }

        if (isset($request->end_time)) {
            $pharmacyInfo->end_time = $request->end_time;
        }

        if (isset($request->break_start_time)) {
            $pharmacyInfo->break_start_time = $request->break_start_time;
        }

        if (isset($request->break_end_time)) {
            $pharmacyInfo->break_end_time = $request->break_end_time;
        }

        $pharmacyInfo->save();

        return $pharmacyInfo;
    }

    public function updateWeekendsAndWorkingHoursInfo($request, $id)
    {
        $weekends = $request->weekends;

        Weekends::where('user_id', $id)->delete();

        foreach ($weekends as $weekend) {
            $weekendDays = new Weekends();
            $weekendDays->user_id = $id;
            $weekendDays->days = $weekend;
            $weekendDays->save();
        }


        $pharmacyInfo = PharmacyBusiness::with('weekends')->where('user_id', $id)->first();

        if (isset($request->start_time)) {
            $pharmacyInfo->start_time = $request->start_time;
        }

        if (isset($request->end_time)) {
            $pharmacyInfo->end_time = $request->end_time;
        }

        if (isset($request->break_start_time)) {
            $pharmacyInfo->break_start_time = $request->break_start_time;
        }

        if (isset($request->break_end_time)) {
            $pharmacyInfo->break_end_time = $request->break_end_time;
        }
        $pharmacyInfo->save();

        return $pharmacyInfo;
    }

    public function getPharmacyInformation($id)
    {
        $pharmacyInfo = User::with('pharmacyBusiness', 'weekends')->find($id);

        return $pharmacyInfo;
    }

    public function updatePharmacyInformation($request, $id)
    {
        $user = User::find($id);



        if (! $user) {
            throw new NotFoundHttpException('Pharmacy user not found');
        }

        if (isset($request->pharmacy_name)) {

            $pharmacyBusinessInfo = PharmacyBusiness::where('user_id', $id)->first();
            if (! $pharmacyBusinessInfo) {
                throw new NotFoundHttpException('Pharmacy Business information not found');
            }
            $pharmacyBusinessInfo->pharmacy_name = $request->pharmacy_name;
            $pharmacyBusinessInfo->save();
        }



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

        if ($request->has('image')) {
            $user->image = $request->get('image');
        }

        $user->save();

        return $user;

    }

    public function getPharmacyBankInformation($id)
    {
        return PharmacyBusiness::where('user_id', $id)->first();
    }

    public function updatePharmacyBankInformation($request, $id)
    {

        $pharmacyBusinessInfo = PharmacyBusiness::where('user_id', $id)->first();

        if (! $pharmacyBusinessInfo) {
            throw new NotFoundHttpException('Pharmacy Business information not found');
        }


        logger($request);

        if ($request->has('bank_account_name')) {
            $pharmacyBusinessInfo->bank_account_name = $request->bank_account_name;
        }

        if ($request->has('bank_account_number')) {
            $pharmacyBusinessInfo->bank_account_number = $request->bank_account_number;
        }

        if ($request->has('bank_name')) {
            logger($request->bank_name);
            $pharmacyBusinessInfo->bank_name = $request->bank_name;
        }

        if ($request->has('bank_brunch_name')) {
            $pharmacyBusinessInfo->bank_brunch_name = $request->bank_brunch_name;
        }

        if ($request->has('bank_routing_number')) {
            $pharmacyBusinessInfo->bank_routing_number = $request->bank_routing_number;
        }

        $pharmacyBusinessInfo->save();

        return $pharmacyBusinessInfo;

    }

    public function checkPharmacyByArea($area_id) {
        $count = PharmacyBusiness::where('area_id', $area_id)->count();
        return $count > 0 ? true : false;
    }

    public function getAvailablePharmacyList($thana_id)
    {
        $pharmacyList = PharmacyBusiness::with(
            ['area.thana'
            => function ($query) use($thana_id) {
                $query->where('id', $thana_id);
            }
            ]
        )->get();

        return $pharmacyList;
    }
}
