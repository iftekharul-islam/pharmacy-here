<?php

namespace Modules\Locations\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Models\User;

class Address extends Model
{
    protected $fillable = ['user_id', 'address', 'thana_id'];

    public function thana()
    {
        return $this->hasOne(Thana::class);
    }


}
