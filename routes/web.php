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
Route::post('create-otp/customer','LoginController@customerCreateOTP')->name('customer.createOTP');
Route::get('login/customer/verify','LoginController@customerOTPForm')->name('customer.OTPForm');
Route::post('verified-otp/login/customer','LoginController@customerVerifyOTP')->name('customer.verifyOTP');
Route::post('logout','LoginController@logout')->name('customer.logout');


// Product routes
Route::get('/medicine',  'ProductsController@index')->name('product-list');
Route::get('/medicine/{medicine_id}',  'ProductsController@show')->name('single-product');

