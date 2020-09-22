<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/', 'HomeController@index')->name('home');


Route::get('/login','LoginController@showCustomerLoginForm')->name('customer.login');
Route::post('create-otp/customer','OtpController@createOtp')->name('customer.createOTP');
Route::get('login/verify-otp/customer','LoginController@customerOTPForm')->name('customer.OTPForm');
Route::post('verified-otp/customer','OtpController@verifyOTP')->name('customer.verifyOTP');
Route::post('logout','LoginController@logout')->name('customer.logout');

// Customer dashboard
Route::get('dashboard','CustomerController@index')->name('customer.details');
Route::post('update/customer/{id}','CustomerController@update')->name('customer.update');

Route::post('store/prescribe','CustomerController@prescriptionStore')->name('prescription.store');

//Route::get('customer/name','LoginController@registerForm')->name('customer.name');
//Route::post('customer/name/update','LoginController@customerNameUpdate')->name('customer.nameUpdate');



// Product routes
Route::get('/medicine',  'ProductsController@index')->name('product-list');
Route::get('/medicine/{medicine_id}',  'ProductsController@show')->name('single-product');
Route::get('/search/medicine-name',  'ProductsController@getProductName');

Route::group(['middleware' => ['customerAuth']], function () {
    Route::group(['prefix' => 'checkout'], function () {
        Route::get('preview', 'CheckoutController@index')->name('checkout.preview');
        Route::post('check-preview', 'CheckoutController@check')->name('checkout.check');
        Route::post('store', 'CheckoutController@store')->name('checkout.store');
    });
});
// Cart
Route::group(['prefix' => 'cart'], function () {
    Route::get('/', 'CartController@index')->name('cart.index');
    Route::get('add-to-cart/{medicine_id}', 'CartController@addToCart')->name('cart.addToCart');
    Route::patch('update-cart', 'CartController@update');
    Route::delete('remove-from-cart', 'CartController@remove');
});


