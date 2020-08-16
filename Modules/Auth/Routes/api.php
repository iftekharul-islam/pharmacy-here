<?php

use Illuminate\Http\Request;
use Modules\Auth\Http\Controllers;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$authNamespace = 'Modules\Auth\Http\Controllers\Api';


$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) use ($authNamespace){
//    $api->group(['prefix' => 'auth'], function ($api) use ($authNamespace) {
        $api->post('login', $authNamespace . '\LoginController@login');
        $api->post('create-otp', $authNamespace . '\RegisterController@createOtp');
        $api->post('verify-otp', $authNamespace . '\RegisterController@verifyOtp');
        $api->post('register', $authNamespace . '\RegisterController@register');
        $api->post('password/email', $authNamespace . '\ForgotPasswordController@sendResetLinkEmail');
        $api->post('password/reset', $authNamespace . '\ResetPasswordController@reset');

        $api->post('login/create-otp', $authNamespace . '\LoginController@createOtp');
        $api->post('login/verify-otp', $authNamespace . '\LoginController@verifyOtp');

        $api->post('pharmacy/register/create-otp', $authNamespace . '\RegisterController@registerPharmacyWithOtp');
        $api->post('pharmacy/register', $authNamespace . '\RegisterController@registerPharmacy');

        $api->post('customer/register', $authNamespace . '\RegisterController@registerCustomer');


//    });
});
