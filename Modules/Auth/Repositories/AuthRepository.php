<?php


namespace Modules\Auth\Repositories;

use Carbon\Carbon;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use JWTAuth;
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
    public function resetNewPassword($email, $password)
    {
        $user = User::where('email', $email)->first();

        $passwordResetResponse = $user->update([
            'password' => bcrypt($password),
        ]);

        if (!$passwordResetResponse) {
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

        if (!$user) {
            throw new UnauthorizedHttpException('', 'Email Not Found');
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
            'email' => $user->email,
            'token' => $token,
        ];

        if (PasswordReset::create($passwordResetData)) {
            $user->notify(new PasswordResetNotification($token));
            return responseData('Password reset link send successfully');
        }

        throw new ResourceException('Failed to send reset link');
    }

    public function createOtp($request)
    {
        $otp = rand(1000, 9999);
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
            throw new UnauthorizedHttpException('', 'Wrong OTP');
        }

        if ($timeDiff >= $lifetime) {

            throw new UnauthorizedHttpException('', 'Timeout');
        }

        return true;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function createUser($request)
    {
        $user = new User();

        $user->phone_number = $request->phone_number;
        $user->name = $request->name;

        if (isset($request->email)) {
            $user->email = $request->email;
        }

        if (isset($request->alternative_phone_number)) {
            $user->alternative_phone_number = $request->alternative_phone_number;
        }

        if (isset($request->dob)) {
            $user->dob = $request->dob;
        }

        if (isset($request->gender)) {
            $user->gender = $request->gender;
        }

        if ($request->role === 'pharmacy') {
            $user->is_pharmacy = true;
        }

        $user->save();


        $role = Role::where('name', $request->role)->first();

        if ($user && $role) {
            $user->assignRole($role);
        }

        $token = JWTAuth::fromUser($user);
        return [
            'token' => $token,
            'user' => $user
        ];
    }

    public function checkPhoneNumber($phone)
    {
        return User::where('phone_number', $phone)->count();
    }

    public function loginWithPhone($phone)
    {
        $user = User::where('phone_number', $phone)->first();

        if (! $user) {
            throw new UnauthorizedHttpException('', 'User Not Found');
        }

        return JWTAuth::fromUser($user);
    }


}
