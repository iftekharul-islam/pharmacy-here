<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Entities\Models\OneTimePassword;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\PhoneValidationRequest;
use Modules\Auth\Repositories\AuthRepository;
use Modules\User\Entities\Models\User;
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

//    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;

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

    public function showLoginForm()
    {
        if (Auth::guard()->check()) {
            return redirect()->route('user.dashboard');
        }
        return view('auth::auth.login');
    }

    public function doLogin(LoginRequest $request)
    {
        $credentials = ['email' => $request->email, 'password' => $request->password];
        if (Auth::guard("web")->attempt($credentials)) {
            if (Auth::guard("web")->check()) {
                return redirect()->route('user.dashboard');
            }
            return redirect()->back()->with('error', 'Wrong email / password provided');
        }

        return redirect()->back()->with('error', 'Wrong email / password provided');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function showCustomerLoginForm()
    {
        if (Auth::guard()->check()) {
            return redirect()->route('customer.dashboard');
        }
        return view('auth::customer.login');

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
//        if (Auth::guard()->check()) {
//            return redirect()->route('customer.dashboard');
//        }
        return view('auth::customer.verify-otp');

    }

    public function customerVerifyOTP(Request $request)
    {
        $otpResponse = $this->repository->verifyOtpWeb($request);
        if ($otpResponse == true) {
            $user = User::where('phone_number', session('phone_number'))->first();

            \Auth::login($user);

            return redirect()->route('product-list');
        }
    }
}
