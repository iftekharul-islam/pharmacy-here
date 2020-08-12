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
    $api->group(['prefix' => 'user', 'middleware' => 'role:pharmacy'], function ($api) use ($namespace) {
        $api->post('pharmacy/name', $namespace . '\UserPharmacyController@name');


        $api->post('me/pharmacy/business', $namespace . '\UserPharmacyController@createBusinessInfo');

        $api->get('me/pharmacy/weekends-and-working-hours', $namespace . '\UserPharmacyController@getWeekendsAndWorkingHoursInfo');
        $api->post('me/pharmacy/weekends-and-working-hours', $namespace . '\UserPharmacyController@createWeekendsAndWorkingHoursInfo');
        $api->put('me/pharmacy/weekends-and-working-hours', $namespace . '\UserPharmacyController@updateWeekendsAndWorkingHoursInfo');

        $api->get('me/pharmacy', $namespace . '\UserPharmacyController@getPharmacyProfile');
        $api->put('me/pharmacy', $namespace . '\UserPharmacyController@updatePharmacyProfile');

        $api->get('me/pharmacy/bank-info', $namespace . '\UserPharmacyController@getPharmacyBankInfo');
        $api->put('me/pharmacy/bank-info', $namespace . '\UserPharmacyController@updatePharmacyBankInfo');
        
        $api->post('me/assets', $namespace . '\AssetController@store');
    });
});
