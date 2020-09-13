<?php


namespace Modules\Locations\Repositories;


use Modules\Locations\Entities\Models\District;

class LocationRepository
{
    public function get()
    {
        return District::with('thanas.areas', function($query){
            return $query->orderby('name', 'asc');
        })->orderBy('name', 'asc')->get();
    }
}
