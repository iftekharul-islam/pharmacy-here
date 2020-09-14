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

Route::get('login/customer','LoginController@showCustomerLoginForm')->name('customer.login');
Route::post('create-otp/customer','LoginController@customerCreateOTP')->name('customer.createOTP');
Route::get('login/customer/verify','LoginController@customerOTPForm')->name('customer.OTPForm');
Route::post('verified-otp/login/customer','LoginController@customerVerifyOTP')->name('customer.verifyOTP');
Route::post('logout','LoginController@logout')->name('logout');
Route::get('login','LoginController@showLoginForm')->name('login');
Route::post('do/login','LoginController@doLogin')->name('do.login');

//Route::group( function () {
//
//    Route::get('login/customer','LoginController@showCustomerLoginForm')->name('customer.login');
//    Route::post('create-otp/customer','LoginController@customerCreateOTP')->name('customer.createOTP');
//    Route::get('login/customer/verify','LoginController@customerOTPForm')->name('customer.OTPForm');
//    Route::post('login/customer/verify','LoginController@customerVerifyOTP')->name('customer.verifyOTP');
//
//
//    Route::get('login','LoginController@showLoginForm')->name('login');
//    Route::post('do/login','LoginController@doLogin')->name('do.login');
//    Route::post('logout','LoginController@logout')->name('logout');
//
//
//});

//Auth::routes();
