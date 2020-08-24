<?php


use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::group(['middleware' => 'web'], function () {
    Route::get('login','LoginController@showLoginForm')->name('login');
    Route::post('do/login','LoginController@doLogin')->name('do.login');
});

//Auth::routes();
