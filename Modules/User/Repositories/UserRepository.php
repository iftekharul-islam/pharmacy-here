<?php

namespace Modules\User\Repositories;


use Carbon\Carbon;
use Modules\Auth\Entities\Models\OneTimePassword;
use Modules\Auth\Jobs\SendOtp;
use Modules\User\Entities\Models\User;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UserRepository {


	public function all() {
		return User::all();
	}

	public function get($id) {

	}

	public function create($request) {
		$user = $request->only('name', 'email', 'password');

		return User::create($user);
	}

	public function delete() {

	}

	public function update() {

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
}
