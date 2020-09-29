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
Route::post('address-store', 'CustomerController@addressStore')->name('customer.address.store');

//Prescription
Route::get('prescription/create', 'PrescriptionController@create');
Route::post('store/prescription','PrescriptionController@store')->name('prescription.store');
Route::post('prescription-id/store', 'PrescriptionController@selectedId')->name('prescriptions.id');
Route::delete('prescription/{id}', 'PrescriptionController@destroy')->name('prescription.destroy');

Route::get('new-customer/name','LoginController@registerForm')->name('customer.name');
Route::post('customer/name/update','LoginController@customerNameUpdate')->name('customer.nameUpdate');

// Product routes
Route::get('/medicine',  'ProductsController@index')->name('product-list');
Route::get('/medicine/{medicine_id}',  'ProductsController@show')->name('single-product');
Route::get('/search/medicine-name',  'ProductsController@getProductName');

Route::group(['middleware' => ['customerAuth']], function () {
    Route::group(['prefix' => 'checkout'], function () {
        Route::get('preview', 'CheckoutController@index')->name('checkout.preview');
        Route::post('check-preview', 'CheckoutController@check')->name('checkout.check');
//        Route::post('store', 'CheckoutController@store')->name('checkout.store');
//        Route::post('pay', 'CheckoutController@sslPayment')->name('ssl.payment');
//        Route::post('success', 'CheckoutController@success')->name('ssl.success');
//        Route::post('fail', 'CheckoutController@fail')->name('ssl.fail');
//        Route::post('cancel', 'CheckoutController@cancel')->name('ssl.cancel');
    });
});
Route::post('store', 'CheckoutController@store')->name('checkout.store');
Route::post('pay', 'CheckoutController@sslPayment')->name('ssl.payment');
Route::post('success', 'CheckoutController@success')->name('ssl.success');
Route::post('fail', 'CheckoutController@fail')->name('ssl.fail');
Route::post('cancel', 'CheckoutController@cancel')->name('ssl.cancel');

// Cart
Route::group(['prefix' => 'cart'], function () {
    Route::get('/', 'CartController@index')->name('cart.index');
    Route::get('add-to-cart/{medicine_id}', 'CartController@addToCart')->name('cart.addToCart');
    Route::patch('update-cart', 'CartController@update');
    Route::delete('remove-from-cart', 'CartController@remove');
});

// SSLCOMMERZ Start
Route::get('/example1', 'SslCommerzPaymentController@exampleEasyCheckout');
Route::get('/example2', 'SslCommerzPaymentController@exampleHostedCheckout');

//Route::post('/pay', 'SslCommerzPaymentController@index');
//Route::post('/pay-via-ajax', 'SslCommerzPaymentController@payViaAjax');

//Route::post('/success', 'SslCommerzPaymentController@success');
//Route::post('/fail', 'SslCommerzPaymentController@fail');
//Route::post('/cancel', 'SslCommerzPaymentController@cancel');

//Route::post('/ipn', 'SslCommerzPaymentController@ipn');
//SSLCOMMERZ END


