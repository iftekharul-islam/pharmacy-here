<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Requests\LoginRequest;

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
                // return redirect()->route('areas');
                // return view('auth::create');
            }
            return redirect()->back()->with('error', 'Wrong email / password provided');

        }

        return redirect()->back()->with('error', 'Wrong email / password provided');
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
