<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
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

    public function customerOTPForm()
    {
        return view('auth.verify-otp');
    }

    public function registerForm()
    {
        if (Auth::guard()->check()) {
            return redirect()->route('customer.dashboard');
        }
        return view('auth.register');

    }

    public function customerNameUpdate(UserCreateRequest $request)
    {
        $user = $this->repository->customerNameUpdate($request);

        if (! $user) {
            throw new UnauthorizedHttpException('', 'User Not Found');
        }

        \Auth::login($user);
        session()->forget('phone_number');

        return redirect()->route('product-list');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('customer.login');
    }
}
