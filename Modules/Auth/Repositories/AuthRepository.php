<?php


namespace Modules\Auth\Repositories;

use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Modules\Auth\Entities\Models\PasswordReset;
use Modules\Auth\Notifications\PasswordResetNotification;
use Modules\User\Models\User;
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
	
	/**
	 * @param $request
	 * @return mixed
	 */
	public function createUser($request)
	{
		return User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password),
		]);
	}
	
	
}
