<?php


namespace Modules\User\Repositories;


use Carbon\Carbon;
use Modules\Address\Entities\CustomerAddress;
use Modules\Locations\Entities\Models\Area;
use Modules\Locations\Entities\Models\District;
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

        if (!$user) {
            throw new NotFoundHttpException('Pharmacy Not Found');
        }
        $user->status = false;
        $user->save();


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

        if (isset($request->is_full_open)) {
            $pharmacyInfo->is_full_open = $request->is_full_open;
        }

        if (isset($request->has_break_time)) {
            $pharmacyInfo->has_break_time = $request->has_break_time;
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

        if (isset($request->is_full_open)) {
            $pharmacyInfo->is_full_open = $request->is_full_open;
        }

        if (isset($request->has_break_time)) {
            $pharmacyInfo->has_break_time = $request->has_break_time;
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

        if (!$user) {
            throw new NotFoundHttpException('Pharmacy user not found');
        }

        if (isset($request->pharmacy_name)) {

            $pharmacyBusinessInfo = PharmacyBusiness::where('user_id', $id)->first();
            if (!$pharmacyBusinessInfo) {
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

    public function getPharmacyBankInformation($id)
    {
        return PharmacyBusiness::where('user_id', $id)->first();
    }

    public function updatePharmacyBankInformation($request, $id)
    {

        $pharmacyBusinessInfo = PharmacyBusiness::where('user_id', $id)->first();

        if (!$pharmacyBusinessInfo) {
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

    public function checkPharmacyByArea($area_id)
    {
        $area = Area::with('thana')->find($area_id);
        $dhaka_district = District::where('slug', 'dhaka')->first();

        $pharmacy = PharmacyBusiness::where('area_id', $area_id)
            ->whereHas('user', function ($q) {
                $q->where('status', 1);
            })->inRandomOrder()->first();

        if (!$pharmacy && $dhaka_district->id != $area->thana->district_id) {
            $pharmacy = PharmacyBusiness::whereHas('area', function ($q) use ($area) {
                $q->where('thana_id', $area->thana_id);
            })->whereHas('user', function ($q) {
                $q->where('status', 1);
            })->inRandomOrder()->first();
        }
        return $pharmacy > 0 ? true : false;
    }

    public function getAvailablePharmacyList($thana_id)
    {
        $pharmacyList = PharmacyBusiness::with('area.thana')
            ->whereHas('area.thana', function ($q) use ($thana_id) {
                $q->where('id', $thana_id);
            })->whereHas('user', function ($q) {
                $q->where('status', 1);
            })->get();

        return $pharmacyList;
    }

    public function getPharmacyInfo($pharmacy_id)
    {
        return User::with('pharmacyBusiness', 'weekends')->find($pharmacy_id);
    }
}
