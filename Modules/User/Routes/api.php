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
        $api->post('pharmacy', $namespace . '\PharmacyController@store');
        $api->put('pharmacy/{id}', $namespace . '\PharmacyController@update');
        $api->delete('pharmacy/{id}', $namespace . '\PharmacyController@destroy');
    });
});
