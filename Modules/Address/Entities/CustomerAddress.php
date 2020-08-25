<?php

namespace Modules\Address\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Locations\Entities\Models\Area;

class CustomerAddress extends Model
{
    protected $table='addresses';
    
    protected $fillable = ['address', 'user_id', 'area_id'];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }
}
