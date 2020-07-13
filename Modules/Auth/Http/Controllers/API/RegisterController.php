<?php

namespace Modules\Auth\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Http\Requests\RegistrationValidationRequest;
use Modules\Auth\Repositories\AuthRepository;

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
     * @param RegistrationValidationRequest $request
     * @return JsonResponse
     */
    public function createOtp(RegistrationValidationRequest $request)
    {
        $otp = $this->repository->createOtp($request);

        if (! $otp) {
            throw new StoreResourceFailedException('Failed to create OTP');
        }

        return responseData('Otp create successful');
    }

    public function verifyOtp(RegistrationValidationRequest $request)
    {
        $user = $this->repository->verifyOtp($request);

        if (! $user) {
            throw new StoreResourceFailedException('Failed to verify OTP');
        }

        return $user;
    }
}
