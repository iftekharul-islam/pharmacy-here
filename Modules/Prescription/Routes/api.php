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
$namespace = 'Modules\Prescription\Http\Controllers\API';


$api = app('Dingo\Api\Routing\Router');

// $api->version('v1', ['middleware' => ['api.auth', 'role:customer']], function ($api) use ($namespace) {
$api->version('v1', ['middleware' => ['api.auth']], function ($api) use ($namespace) {
    $api->get('customer/prescriptions/', $namespace . '\PresriptionController@customerPrescriptons');
    $api->get('prescription/{id}', $namespace . '\PresriptionController@show');
    $api->post('prescription/create', $namespace . '\PresriptionController@create');
    $api->put('prescription/update/{id}', $namespace . '\PresriptionController@update');
    $api->delete('prescription/delete/{id}', $namespace . '\PresriptionController@destroy');
});
