<?php


namespace Modules\Auth\Repositories;

use JWTAuth;
use Carbon\Carbon;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Modules\Auth\Entities\Models\OneTimePassword;
use Modules\Auth\Entities\Models\PasswordReset;
use Modules\Auth\Jobs\SendOtp;
use Modules\Auth\Notifications\PasswordResetNotification;
use Modules\User\Entities\Models\User;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthRepository
{

	/**
	 * @param $request
	 * @return mixed
	 */
	public function getUserInfo($request)
	{
		$userToken = PasswordReset::where('token', $request->token)->first();

		return PasswordReset::where('email', $userToken->email)->latest()->first();

	}

	/**
	 * @param $email
	 * @param $password
	 * @return mixed
	 */
	public function resetNewPassword($email,$password)
	{
		$user = User::where('email', $email)->first();

		$passwordResetResponse = $user->update([
			'password' => bcrypt($password),
		]);

		if (! $passwordResetResponse) {
			throw new UpdateResourceFailedException('Password change Failed');
		}

		return responseData('Password changed successful');

	}

	/**
	 * @param $email
	 * @return mixed
	 */
	public function getUserByEmail($email)
	{
		$user = User::where('email', $email)
		            ->first();

		if (! $user ) {
			throw new UnauthorizedHttpException('','Email Not Found');
		}

		return $user;
	}

	/**
	 * @param $user
	 * @param $token
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function createPasswordResetData($user, $token)
	{
		$passwordResetData = [
			'email' =>  $user->email,
			'token' => $token,
		];

		if (PasswordReset::create($passwordResetData)) {
			$user->notify(new PasswordResetNotification($token));
			return responseData('Password reset link send successfully');
		}

		throw new ResourceException('Failed to send reset link');
	}



    public function createOtp($request) {
        $otp = rand(100000, 999999);
        $phone = $request->phone_number;
        SendOtp::dispatch($phone, $otp);
        return $otp;
    }

    public function verifyOtp($request)
    {
        $lifetime = config('auth.sms.lifetime');
        $phone_number = $request->phone_number;
        $otp = OneTimePassword::where('phone_number', $phone_number)->latest()->first();
        $created_at = new Carbon($otp->created_at);
        $timeDiff = $created_at->diffInSeconds(Carbon::now());
        if (trim($otp->otp) !== trim($request->input('otp'))) {
            return [
                'error' => true,
                'message' => 'wrongOtp'
            ];
        }

        if ($timeDiff >= $lifetime) {
            return [
                'error' => true,
                'message' => 'timeout'
            ];
        }

        return $this->createUser($request);

    }

    /**
     * @param $request
     * @return mixed
     */
	public function createUser($request)
	{
        $user = User::create([
            'phone_number' => $request->phone_number
        ]);

        $role = Role::where('name', $request->role)->first();

        if ($user && $role) {
            $user->assignRole($role);
        }

        $token = JWTAuth::fromUser($user);
        return [
            'error' => false,
            'newUser' => true,
            'token' => $token,
            'user' => $user
        ];
	}


}
