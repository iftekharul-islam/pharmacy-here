<?php


namespace Modules\Auth\Repositories;

use Carbon\Carbon;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Illuminate\Support\Str;
use JWTAuth;
use Modules\Auth\Entities\Models\OneTimePassword;
use Modules\Auth\Entities\Models\PasswordReset;
use Modules\Auth\Jobs\SendOtp;
use Modules\Auth\Notifications\PasswordResetNotification;
use Modules\Points\Entities\Models\Points;
use Modules\Points\Entities\Models\Refers;
use Modules\User\Entities\Models\PharmacyBusiness;
use Modules\User\Entities\Models\User;
use Modules\User\Entities\Models\UserDeviceId;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        SendOtp::dispatch($request->phone_number, $otp);
        return $otp;
    }

    public function createOtpWeb($request)
    {
        $otp = rand(1000, 9999);
        SendOtp::dispatch($request->phone_number, $otp);
        return $otp;
    }

    public function verifyOtp($request)
    {
        $lifetime = config('auth.sms.lifetime');
        $otp = OneTimePassword::where('phone_number', $request->get('phone_number'))->latest()->first();
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

    public function verifyOtpWeb($request)
    {
        $lifetime = config('auth.sms.lifetime');

        $otp = OneTimePassword::where('phone_number', session()->get('phone_number'))->latest()->first();

        $created_at =new Carbon($otp->created_at);
        $timeDiff = $created_at->diffInSeconds(Carbon::now());
        if (trim($otp->otp) !== trim($request->input('otp'))) {
            return false;
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
    public function createPharmacyUser($request)
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

        $user->status = false;

        $user->save();

        UserDeviceId::create([
            'user_id' => $user->id,
            'device_id' => $request->device_token,
        ]);

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

    public function isActivePhoneNumber($phone)
    {
        return User::where('phone_number', $phone)->where('status', 0)->count();
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

    public function getUserByPhone($phone, $device_token)
    {
        $user = User::where('phone_number', $phone)->first();

        $count_device_id = UserDeviceId::where('device_id', $device_token)->count();

        if ($count_device_id < 1)
        {
            UserDeviceId::create([
                'user_id' => $user->id,
                'device_id' => $device_token,
            ]);
        }



        if ($user->hasRole('pharmacy')) {
            return User::with('pharmacyBusiness', 'weekends')->where('phone_number', $phone)->first();
        }
        return User::where('phone_number', $phone)->first();
    }

    public function createCustomerUser($request)
    {
        $user = new User();

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('phone_number')) {
            $user->phone_number = $request->phone_number;
        }
        $user->referral_code = Str::random(7);

        $user->save();

        $role = Role::where('name', 'customer')->first();

        if ($user && $role) {
            $user->assignRole($role);
        }

        if ($request->has('referral_code') && $request->get('referral_code')) {
            $referred_user = User::where('referral_code', $request->referral_code)->first();

            if (! $referred_user) {
                throw new NotFoundHttpException('Referral code not found');
            }

            $refers = new Refers();
//                Refers::create([
//                'refered_by' => $referred_user->id,
//                'refered_to' => $user->id,
//            ]);
            $refers->referred_by = $referred_user->id;
            $refers->referred_to = $user->id;
            $refers->save();


            Points::create([
                'user_id' => $referred_user->id,
                'points' => 10,
                'type' => 'referred',
                'type_id' => $refers->id,
            ]);

            Points::create([
                'user_id' => $user->id,
                'points' => 10,
                'type' => 'referred',
                'type_id' => $refers->id,
            ]);

        }

        return $this->createOtp($request);
    }

    public function customerNameUpdate($request)
    {
        $user = User::where('phone_number', session()->get('phone_number'))->first();

        if ($request->has('name')) {
            $user->name = $request->name;
        }
        $role = Role::where('name', 'customer')->first();
        $user->assignRole($role);
        $user->save();

        return $user;
    }

    public function createCustomerWeb($request)
    {
        $user = new User();

        if ($request->has('phone_number')) {
            $user->phone_number = $request->phone_number;
            session()->put('phone_number', $user->phone_number);
        }

        $user->save();

        $role = Role::where('name', 'customer')->first();

        if ($user && $role) {
            $user->assignRole($role);
        }

        return $this->createOtpWeb($request);
    }

    public function getUserState($user)
    {
        $pharmacy_business = $user->pharmacyBusiness;

        if ($pharmacy_business == null) {
            return 2;
        }
        if ($pharmacy_business->pharmacy_name == null) {
            return 2;
        }
        if ($pharmacy_business->pharmacy_address == null) {
            return 2;
        }
        if ($pharmacy_business->nid_img_path == null) {
            return 2;
        }
        if ($pharmacy_business->trade_img_path == null) {
            return 2;
        }
        if ($pharmacy_business->drug_img_path == null) {
            return 2;
        }

        if ($pharmacy_business->start_time == null) {
            return 3;
        }
        if ($pharmacy_business->end_time == null) {
            return 3;
        }

        $weekends = $user->weekends;
        if (empty($weekends)) {
            return 3;
        }

        return 0;

    }


}
