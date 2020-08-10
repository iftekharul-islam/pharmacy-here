<?php

namespace Modules\Locations\Entities\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['user_id', 'address', 'area_id'];

    public function area()
    {
        return $this->hasOne(Area::class);
    }


}
