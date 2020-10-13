<?php

namespace Modules\User\Entities\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Address\Entities\CustomerAddress;
use Modules\Auth\Notifications\PasswordResetNotification;
use Modules\Locations\Entities\Models\Address;
use Modules\Points\Entities\Models\Points;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles, SoftDeletes;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone_number', 'name', 'is_pharmacy', 'email', 'image', 'gender', 'dob', 'status', 'alternative_phone_number', 'image', 'password', 'is_active', 'referral_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	public function setPasswordAttribute($password)
	{
		$this->attributes['password'] = bcrypt($password);
	}

    public function adminlte_image()
    {
        return 'https://picsum.photos/300/300';
    }

    public function adminlte_desc()
    {
        return 'That\'s a nice guy';
    }

    public function adminlte_profile_url()
    {
        return 'profile/username';
    }

    public function address()
    {
        return $this->hasMany(Address::class);
    }

    public function pharmacyBusiness()
    {
        return $this->hasOne(PharmacyBusiness::class, 'user_id', 'id');
    }

    public function weekends()
    {
        return $this->hasMany(Weekends::class, 'user_id', 'id');
    }

    public function customerAddress()
    {
        return $this->hasMany(CustomerAddress::class, 'user_id', 'id')->orderBy('id', 'ASC');
    }

//    public function points()
//    {
//        return $this->hasMany(Points::class, 'user_id','id');
//    }


}
