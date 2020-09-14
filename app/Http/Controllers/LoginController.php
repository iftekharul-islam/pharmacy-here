<?php

namespace App\Http\Controllers;

use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Requests\PhoneValidationRequest;
use Modules\Auth\Repositories\AuthRepository;
use Modules\User\Entities\Models\User;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class LoginController extends Controller
{
    private $repository;

    public function __construct(AuthRepository $repository)
    {
        $this->middleware('guest')->except('logout');
        $this->repository = $repository;
    }

    public function showCustomerLoginForm()
    {
        if (Auth::guard()->check()) {
            return redirect()->route('customer.dashboard');
        }
        return view('auth.login');

    }

    public function customerCreateOTP(PhoneValidationRequest $request)
    {
        $verifyNumber = $this->repository->checkPhoneNumber($request->phone_number);

        if (!$verifyNumber) {
            throw new UnauthorizedHttpException('', 'Phone Number is not registered');
        }

        $otp = $this->repository->createOtp($request);

        if (!$otp) {
            throw new StoreResourceFailedException('Failed to create OTP');
        }
        return redirect()->route('customer.OTPForm');
    }

    public function customerOTPForm()
    {
        return view('auth.verify-otp');
    }

    public function customerVerifyOTP(Request $request)
    {
        $otpResponse = $this->repository->verifyOtpWeb($request);
        if ($otpResponse == true) {
            $user = User::where('phone_number', $request->session()->get('phone_number'))->first();

            \Auth::login($user);

            return redirect()->route('product-list');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('customer.login');
    }
}
