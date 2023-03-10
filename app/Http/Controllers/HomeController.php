<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function terms()
    {
        return view('terms-page');
    }
    public function faq()
    {
        return view('faq-page');
    }

    public function refundPage()
    {
        return view('refund-page');
    }

    public function privacyPage()
    {
        return view('privacy-page');
    }

    public function about()
    {
        return view('about-page');
    }

}
