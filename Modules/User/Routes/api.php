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
//        $api->post('pharmacy', $namespace . '\UserPharmacyController@store');
//        $api->put('pharmacy/{id}', $namespace . '\UserPharmacyController@update');
//        $api->delete('pharmacy/{id}', $namespace . '\UserPharmacyController@destroy');
        $api->post('pharmacy/name', $namespace . '\UserPharmacyController@name');


        $api->post('me/pharmacy/business', $namespace . '\UserPharmacyController@createBusinessInfo');
        $api->post('me/pharmacy/weekends-and-working-hours', $namespace . '\UserPharmacyController@createWeekendsAndWorkingHoursInfo');

    });
});
