<?php


namespace Modules\Locations\Repositories;


use Modules\Locations\Entities\Models\District;

class LocationRepository
{
    public function get()
    {
        return District::orderBy('name', 'ASC')->get();
    }
}
