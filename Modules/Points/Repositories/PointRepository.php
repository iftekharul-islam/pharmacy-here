<?php


namespace Modules\Points\Repositories;


use Carbon\Carbon;
use Faker\Provider\DateTime;
use Modules\Points\Entities\Models\Points;

class PointRepository
{
    public function playstoreRating($customer_id)
    {
        return Points::create([
            'user_id' => $customer_id,
            'points' => config('subidha.google_playstore_rating_point'),
            'type' => 'playstore',
        ]);
    }

    public function createManualPoints($request)
    {
        return Points::create([
            'user_id' => $request->customer_id,
            'points' => $request->point,
            'type' => 'manual',
        ]);
    }

    public function alarmPoint($user_id)
    {
        $first_day = date('Y-m-01 00:00:00');

        if ($first_day === Carbon::today()) {
            $existAlarm = Points::where('user_id', $user_id)->where('type', 'alarm')->where('created_at', $first_day)->first();

            if (!$existAlarm) {
                $data = Points::create([
                    'user_id' => $user_id,
                    'points' => config('subidha.point_on_first_use'),
                    'type' => 'alarm',
                ]);
                return $data;
            }
            return true;
        }
        return false;
    }

}
