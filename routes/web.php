<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

//localization
Route::get('/locale/{locale}', 'LocalizationController');


// Basic pages
Route::get('/', 'HomeController@index')->name('home');
Route::get('/terms-of-use', 'HomeController@terms')->name('terms');
Route::get('/faq', 'HomeController@faq')->name('faq');
Route::get('/refund-&-return-policy', 'HomeController@refundPage')->name('return.page');
Route::get('/privacy-policy', 'HomeController@privacyPage')->name('privacy.page');
Route::get('/about-page', 'HomeController@about')->name('about.page');

// User login
Route::get('/login','LoginController@showCustomerLoginForm')->name('customer.login');
Route::post('create-otp/customer','OtpController@createOtp')->name('customer.createOTP');
Route::get('login/verify-otp/customer','LoginController@customerOTPForm')->name('customer.OTPForm');
Route::post('verified-otp/customer','OtpController@verifyOTP')->name('customer.verifyOTP');
Route::post('logout','LoginController@logout')->name('customer.logout');

//New customer
Route::get('new-customer/name','LoginController@registerForm')->name('customer.name');
Route::post('customer/name/update','LoginController@customerNameUpdate')->name('customer.nameUpdate');

//medicine
Route::get('/medicine',  'ProductsController@index')->name('product-list');
Route::get('/medicine/{medicine_id}/{medicine_slug}',  'ProductsController@show')->name('single-product');
Route::get('/search/medicine-name',  'ProductsController@getProductName');

Route::group(['middleware' => ['customerAuth']], function () {
    Route::group(['prefix' => 'checkout'], function () {
        Route::get('preview', 'CheckoutController@index')->name('checkout.preview');
        Route::post('check-preview', 'CheckoutController@check')->name('checkout.check');
    });

    //Prescription
    Route::get('prescription/create', 'PrescriptionController@create')->name('prescription.create');
    Route::post('store/prescription','PrescriptionController@store')->name('prescription.store');
    Route::post('prescription-id/store', 'PrescriptionController@selectedId')->name('prescriptions.id');
    Route::delete('prescription/{id}', 'PrescriptionController@destroy')->name('prescription.destroy');

    //order route
    Route::get('customer-order/{id}','OrderController@show')->name('order.details');

    // Customer dashboard
    Route::get('customer/dashboard','CustomerController@index')->name('customer.details');
    Route::post('update/customer/{id}','CustomerController@update')->name('customer.update');
    Route::post('address-store', 'CustomerController@addressStore')->name('customer.address.store');

    Route::group(['prefix' => 'cart'], function () {
        Route::get('/', 'CartController@index')->name('cart.index');
        Route::post('order-to-cart', 'CartController@orderToCart')->name('order.to.cart');
    });
});

// Cart
Route::group(['prefix' => 'cart'], function () {
    Route::get('add-to-cart/{medicine_id}', 'CartController@addToCart')->name('cart.addToCart');
    Route::put('update-cart', 'CartController@update')->name('update.cart');
    Route::delete('remove-from-cart', 'CartController@remove')->name('delete.cart');
    Route::get('find-from-cart', 'CartController@findCart')->name('find.cart');
});

Route::get('cart-count', 'CartController@cartCount')->name('cart.count');

Route::post('store', 'CheckoutController@store')->name('checkout.store');
Route::post('pay', 'CheckoutController@sslPayment')->name('ssl.payment');
Route::post('success', 'CheckoutController@success')->name('ssl.success');
Route::post('fail', 'CheckoutController@fail')->name('ssl.fail');
Route::post('cancel', 'CheckoutController@cancel')->name('ssl.cancel');
Route::post('ipn', 'CheckoutController@ipn');


//Find pharmacy for checkout
Route::get('find-pharmacy', 'CheckoutController@findPharmacy')->name('find.pharmacy');
Route::get('find-pharmacy-list', 'CheckoutController@availablePharmacyList')->name('find.pharmacy.list');

