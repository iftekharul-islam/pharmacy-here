<?php

namespace Modules\Auth\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Http\Requests\CustomerRegistrationRequest;
use Modules\Auth\Http\Requests\PharmacyRegistrationRequest;
use Modules\Auth\Http\Requests\PhoneValidationRequest;
use Modules\Auth\Repositories\AuthRepository;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    private $repository;

    /**
     * Create a new controller instance.
     *
     * @param AuthRepository $registerRepository
     */
    public function __construct(AuthRepository $registerRepository)
    {
        $this->middleware('guest');
        $this->repository = $registerRepository;
    }

    /**
     * @param PhoneValidationRequest $request
     * @return JsonResponse
     */
    public function createOtp(PhoneValidationRequest $request)
    {
        $otp = $this->repository->createOtp($request);

        if (! $otp) {
            throw new StoreResourceFailedException('Failed to create OTP');
        }

        return responseData('Otp creation successful');
    }

    public function verifyOtp(PhoneValidationRequest $request)
    {
        $otpResponse = $this->repository->verifyOtp($request);

        if (! $otpResponse) {
            throw new StoreResourceFailedException('Failed to verify OTP');
        }

        $token = $this->repository->loginWithPhone($request->phone_number);

        return $this->respondWithToken($token);

//        return response()->json([
//            'data' => [
//                'verify_otp' => true,
//            ]
//        ]);
    }

    public function registerPharmacyWithOtp(PhoneValidationRequest $request)
    {
        $isPhoneExists = $this->repository->checkPhoneNumber($request->phone_number);

        if ($isPhoneExists) {
            throw new UnauthorizedHttpException('','Phone Number exists!');
        }

        $otp = $this->repository->createOtp($request);

        if (! $otp) {
            throw new StoreResourceFailedException('Failed to create OTP');
        }

        return responseData('Otp create successful');
    }

    public function registerPharmacy(PharmacyRegistrationRequest $request)
    {
        $user = $this->repository->createPharmacyUser($request);

        if (! $user) {
            throw new StoreResourceFailedException('Pharmacy registration unsuccessful');
        }

        return $user;
    }

    public function registerCustomer(CustomerRegistrationRequest $request)
    {
//        return $request->all();

        $responseInfo = $this->repository->createCustomerUser($request);;

        if (! $responseInfo) {
            throw new StoreResourceFailedException('Failed to create OTP');
        }

        return responseData('Otp creation successful');
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $this->guard()->factory()->getTTL()
        ]);
    }
}
