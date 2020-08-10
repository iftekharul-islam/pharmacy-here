<?php


namespace Modules\User\Repositories;


use Modules\User\Entities\Models\PharmacyBusiness;
use Modules\User\Entities\Models\User;
use Modules\User\Entities\Models\Weekends;
use Monolog\Logger;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PharmacyRepository
{
    public function createBusinessInfo($request, $id)
    {
        $pharmacyBusiness = new PharmacyBusiness();

        if ($request->file('nid_image')) {
            $image = $request->file('nid_image');
            $image_name =$image->storeAs( 'nid_' . time() .'.jpg');
//            $pharmacyBusiness->nid_img_path = $request->file('nid_image')->save(storage_path('app/public/image/'), $image_name, 'public');
            $pharmacyBusiness->nid_img_path = "https://dummyimage.com/600x400/000/fff";
        }

        if ($request->file('trade_licence')) {
            $image = $request->file('trade_licence');
            $image_name =$image->storeAs( 'trade_licence_' . time() .'.jpg');
//            $pharmacyBusiness->trade_img_path = $request->file('trade_licence')->save(storage_path('app/public/image/'), $image_name, 'public');
            $pharmacyBusiness->trade_img_path = "https://dummyimage.com/600x400/000/fff";
        }

        if ($request->file('drug_licence')) {
            $image = $request->file('drug_licence');
            $image_name =$image->storeAs( 'trade_licence_' . time() .'.jpg');
//            $pharmacyBusiness->drug_img_path = $request->file('drug_licence')->save(storage_path('app/public/image/'), $image_name, 'public');
            $pharmacyBusiness->drug_img_path = "https://dummyimage.com/600x400/000/fff";
        }

//        if ($request->file('nid_image')) {
//            $pharmacyBusiness->nid_img_path = Storage::disk('s3')->put('pharmacy/nid', $request->nid_image);
//        }
//
//        if ($request->file('trade_license_image')) {
//            $pharmacyBusiness->trade_img_path = Storage::disk('s3')->put('pharmacy/trade', $request->trade_license_image);
//        }
//
//        if ($request->file('drug_license_image')) {
//            $pharmacyBusiness->drug_img_path = Storage::disk('s3')->put('pharmacy/drugs', $request->drug_license_image);
//        }

        if (isset($request->pharmacy_name)) {
            $pharmacyBusiness->pharmacy_name = $request->pharmacy_name;
        }

        if (isset($request->pharmacy_address)) {
            $pharmacyBusiness->pharmacy_address = $request->pharmacy_address;
        }

        if (isset($request->area_id)) {
            $pharmacyBusiness->area_id = $request->area_id;
        }

        if (isset($request->bank_account)) {
            $pharmacyBusiness->bank_account = $request->bank_account;
        }

        if (isset($request->bkash_number)) {
            $pharmacyBusiness->bkash_number = $request->bkash_number;
        }

        $pharmacyBusiness->user_id = $id;

        $pharmacyBusiness->save();

        return $pharmacyBusiness;


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

        return $pharmacyInfo->save();
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

        $user->save();

        return $user;

    }
}
