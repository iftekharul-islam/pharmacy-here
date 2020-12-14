<?php

namespace Modules\User\Repositories;


use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Entities\Models\OneTimePassword;
use Modules\Auth\Jobs\SendOtp;
use Modules\User\Entities\Models\User;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UserRepository
{


    public function all()
    {
        return User::all();
    }

    public function viewAdmin()
    {
        return User::find(Auth::user()->id);
    }

    public function adminUpdate($request, $id)
    {
        $user = user::find($id);
        if (!$user) {
            return false;
        }
        $data = $request->only('password');
        if (isset($data['password'])) {
            $user->password = $data['password'];
        }
        $user->save();

        return true;
    }

    public function get($id)
    {

    }

    public function create($request)
    {
        $user = $request->only('name', 'email', 'password');

        return User::create($user);
    }

    public function update()
    {

    }

    public function createOtp($phone)
    {
        $otp = rand(1000, 9999);
        SendOtp::dispatch($phone, $otp);
        return $otp;
    }

    public function verifyOtp($request, $phone_number)
    {
        $lifetime = config('auth.sms.lifetime');
        $otp = OneTimePassword::where('phone_number', $phone_number)->latest()->first();
        $created_at = new Carbon($otp->created_at);
        $timeDiff = $created_at->diffInSeconds(Carbon::now());
        if (trim($otp->otp) !== trim($request->input('otp'))) {
            throw new UnauthorizedHttpException('', 'Wrong OTP');
        }

        if ($timeDiff >= $lifetime) {

            throw new UnauthorizedHttpException('', 'Timeout');
        }

        return true;
    }

    public function getAllCustomer()
    {
//        return User::role('customer')->get();
        return User::where('is_admin', 0)->where('is_pharmacy', 0)->get();
    }
}
