<?php

namespace App\Http\Controllers;

use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Modules\Auth\Http\Requests\PhoneValidationRequest;
use Modules\Auth\Repositories\AuthRepository;
use Modules\User\Entities\Models\User;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class OtpController extends Controller
{
    private $repository;

    public function __construct(AuthRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createOtp(PhoneValidationRequest $request)
    {
        $verifyNumber = $this->repository->checkPhoneNumber($request->phone_number);

        if (!$verifyNumber) {
            throw new UnauthorizedHttpException('', 'Phone Number is not registered');
        }

        $otp = $this->repository->createOtpWeb($request);

        if (!$otp) {
            throw new StoreResourceFailedException('Failed to create OTP');
        }
        return redirect()->route('customer.OTPForm');
    }



    public function verifyOTP(Request $request)
    {
        $otpResponse = $this->repository->verifyOtpWeb($request);
        if ($otpResponse == true) {
            $user = User::where('phone_number', session()->get('phone_number'))->first();

            \Auth::login($user);
            session()->forget('phone_number');
            return redirect()->route('product-list');
        }
    }
}
