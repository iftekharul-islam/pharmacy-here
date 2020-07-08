<?php


namespace Modules\Auth\Repositories;


use App\User;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Modules\Auth\Entities\Models\PasswordReset;

class ResetPasswordRepository
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
}
