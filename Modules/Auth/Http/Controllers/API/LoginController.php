<?php

namespace Modules\Auth\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Requests\LoginValidationRequest;
use Modules\Auth\Http\Requests\PhoneValidationRequest;
use Modules\Auth\Repositories\AuthRepository;
use Modules\User\Entities\Models\UserDeviceId;
use Symfony\Component\Finder\Exception\AccessDeniedException;
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

    private $repository;

    /**
     * Create a new controller instance.
     *
     * @param AuthRepository $repository
     */
    public function __construct(AuthRepository $repository)
    {
        $this->middleware('guest')->except('logout');
        $this->repository = $repository;
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

        throw new UnauthorizedHttpException('', 'Unauthorized User');
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
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL()
        ]);
    }

    public function guard()
    {
        return Auth::guard();
    }

    public function createOtp(PhoneValidationRequest $request)
    {
//        $isActivePhone = $this->repository->isActivePhoneNumber($request->phone_number);

//        if ($isActivePhone) {
//            throw new AccessDeniedException('Pharmacy is inactive !',403);
//        }
        $verifyNumber = $this->repository->checkPhoneNumber($request->phone_number);

        if (!$verifyNumber) {
            throw new UnauthorizedHttpException('', 'Phone Number is not registered');
        }

        $otp = $this->repository->createOtp($request);


        if (!$otp) {
            throw new StoreResourceFailedException('Failed to create OTP');
        }

        return responsePreparedData($otp);
//        return responseData('Otp creation successful');
    }

    public function verifyOtp(PhoneValidationRequest $request)
    {
        $user_state = 0;
        $otpResponse = $this->repository->verifyOtp($request);

        if (!$otpResponse) {
            throw new StoreResourceFailedException('Failed to verify OTP');
        }


        $token = $this->repository->loginWithPhone($request->phone_number);

        if (!$token) {
            throw new StoreResourceFailedException('Failed to verify OTP');
        }

        $user = $this->repository->getUserByPhone($request->phone_number, $request->device_token);

        if ($user->hasRole('pharmacy')) {
            $user_state = $this->repository->getUserState($user);
        }
//        return $user;
        $storeDevice = $this->repository->deviceStore($request);

        return $this->respondWithTokenAndName($token, $user, $user_state);

//        return $this->respondWithToken($token);
    }

    public function respondWithTokenAndName($token, $user, $user_state)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user_state' => $user_state,
            // 'expires_in'   => $this->guard()->factory()->getTTL(),
            'user' => $user,
        ]);
    }
}
