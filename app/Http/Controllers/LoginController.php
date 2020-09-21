<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Repositories\AuthRepository;
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

    public function customerOTPForm()
    {
        return view('auth.verify-otp');
    }


//    public function customerNameUpdate(UserCreateRequest $request)
//    {
//        $user = $this->repository->customerNameUpdate($request);
//
//        if (! $user) {
//            throw new UnauthorizedHttpException('', 'User Not Found');
//        }
//
//        \Auth::login($user);
//        session()->forget('phone_number');
//
//        return redirect()->route('home');
//    }

    public function logout()
    {
        session()->forget('cart');
        session()->forget('cartCount');
        Auth::logout();
        return redirect()->route('customer.login');
    }
}
