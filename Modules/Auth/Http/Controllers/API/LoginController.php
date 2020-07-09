<?php

namespace Modules\Auth\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Requests\LoginValidationRequest;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
	
	/**
	 * @param LoginValidationRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function login(LoginValidationRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        throw new UnauthorizedHttpException('','Unauthorized User');
    }
	
	/**
	 * @param $token
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $this->guard()->factory()->getTTL()
        ]);
    }

    public function guard()
    {
        return Auth::guard();
    }
}
