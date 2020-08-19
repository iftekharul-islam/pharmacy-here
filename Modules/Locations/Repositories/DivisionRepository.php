<?php


namespace Modules\Locations\Repositories;


use Modules\Locations\Entities\Models\Division;

class DivisionRepository
{
    public function get()
    {
        // return District::with('thanas.areas')->get();
        return Division::get();
        // return District::get();
    }
}
