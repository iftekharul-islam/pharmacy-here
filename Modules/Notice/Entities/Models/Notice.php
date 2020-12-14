<?php

namespace Modules\Notice\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Notice\Entities\UserNotice;
use Modules\User\Entities\Models\PharmacyBusiness;

class Notice extends Model
{
    use SoftDeletes;
    protected $table = 'notice_board';
    protected $fillable = ['notice', 'bn_notice', 'status', 'type'];

    public function UserNotices()
    {
        return $this->hasMany(UserNotice::class , 'notice_id', 'id');
    }
}
