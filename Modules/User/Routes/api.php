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

$authNamespace = 'Modules\User\Http\Controllers\API';


$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => ['api.auth', 'role:admin']], function ($api) use ($authNamespace) {
	$api->post('users',  $authNamespace . '\UserController@store');
	
	$api->resource('roles', $authNamespace . '\RoleController');
});
