<?php

use Illuminate\Http\Request;

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

$namespace = 'Modules\User\Http\Controllers\API';


$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => ['api.auth', 'role:admin']], function ($api) use ($namespace) {
	$api->post('users',  $namespace . '\UserController@store');

	$api->resource('roles', $namespace . '\RoleController');
});


$api->version('v1', function ($api) use ($namespace) {
    $api->group(['prefix' => 'user', 'middleware' => 'jwt.auth'], function ($api) use ($namespace) {
        $api->post('pharmacy/name', $namespace . '\UserPharmacyController@name');


        $api->post('me/pharmacy/business', $namespace . '\UserPharmacyController@createBusinessInfo');

        $api->get('me/pharmacy/weekends-and-working-hours', $namespace . '\UserPharmacyController@getWeekendsAndWorkingHoursInfo');
        $api->post('me/pharmacy/weekends-and-working-hours', $namespace . '\UserPharmacyController@createWeekendsAndWorkingHoursInfo');
        $api->put('me/pharmacy/weekends-and-working-hours', $namespace . '\UserPharmacyController@updateWeekendsAndWorkingHoursInfo');

        $api->get('me/pharmacy', $namespace . '\UserPharmacyController@getPharmacyProfile');
        $api->put('me/pharmacy', $namespace . '\UserPharmacyController@updatePharmacyProfile');

        $api->get('me/pharmacy/bank-info', $namespace . '\UserPharmacyController@getPharmacyBankInfo');
        $api->put('me/pharmacy/bank-info', $namespace . '\UserPharmacyController@updatePharmacyBankInfo');

        $api->post('me/create-otp', $namespace . '\UserController@createOtp');
        $api->post('me/verify-otp', $namespace . '\UserController@verifyOtp');

        $api->get('me/customer', $namespace . '\UserCustomerController@show');
        $api->put('me/customer', $namespace . '\UserCustomerController@update');
    });

    $api->get('pharmacy/available/{area_id}', $namespace . '\UserPharmacyController@isPharmacyAvailable');
    $api->get('pharmacy/available-list/{thana_id}', $namespace . '\UserPharmacyController@availablePharmacyList');

    $api->post('pharmacy/info-check', $namespace . '\UserPharmacyController@pharmacyInfoCheck');
});

$api->version('v1', function ($api) use ($namespace) {
	$api->post('me/assets', $namespace . '\AssetController@store');
	$api->post('me/notification', $namespace . '\AssetController@notification');

	$api->get('banks', $namespace . '\BankController@index');
});
