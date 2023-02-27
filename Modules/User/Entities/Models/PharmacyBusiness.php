<?php

namespace Modules\User\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Locations\Entities\Models\Address;
use Modules\Locations\Entities\Models\Area;
use Modules\Orders\Entities\Models\Order;
use Modules\Orders\Entities\Models\TransactionHistory;

class PharmacyBusiness extends Model
{
    protected $fillable = [
        'pharmacy_name',
        'pharmacy_address',
        'bank_account_name',
        'bank_account_number',
        'bank_name',
        'bank_brunch_name',
        'bkash_number',
        'start_time',
        "end_time",
        "break_start_time",
        "break_end_time",
        'user_id',
        'area_id',
        'bank_routing_number',
        'is_full_open',
        'has_break_time',
        'nid_img_path',
        'trade_img_path',
        'drug_img_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function weekends()
    {
        return $this->hasMany(Weekends::class, 'user_id', 'user_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }

    public function bank()
    {
        return $this->belongsTo(BankName::class, 'bank_id', 'id');
    }

    public function pharmacyOrder()
    {
        return $this->hasMany(Order::class, 'pharmacy_id', 'user_id');
    }

    public function pharmacyTransaction()
    {
        return $this->hasMany(TransactionHistory::class, 'pharmacy_id', 'user_id');
    }

}
