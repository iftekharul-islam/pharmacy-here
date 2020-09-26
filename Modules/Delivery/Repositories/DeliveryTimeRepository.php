<?php


namespace Modules\Delivery\Repositories;


use Modules\Delivery\Entities\Models\DeliveryTime;

class DeliveryTimeRepository
{
    public function timeList($type)
    {
        return DeliveryTime::where('type', $type)->get();
    }
}
