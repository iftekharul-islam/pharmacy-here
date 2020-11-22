<?php


namespace Modules\Points\Repositories;


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

}
