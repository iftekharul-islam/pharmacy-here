<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    /**
     * @param $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke($locale)
    {
        Session::put('locale', $locale);
        return back();
    }
}
