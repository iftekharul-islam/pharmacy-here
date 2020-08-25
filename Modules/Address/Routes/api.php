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

$namespace = 'Modules\Address\Http\Controllers\API';


$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) use ($namespace) {
    $api->group(['middleware' => 'jwt.auth'], function ($api) use ($namespace) {
        $api->get('addresses', $namespace . '\AddressController@customerAddresses');
        $api->post('address/create', $namespace . '\AddressController@create');
        $api->put('address/update/{id}', $namespace . '\AddressController@update');
        $api->delete('address/delete/{id}', $namespace . '\AddressController@destroy');
    });
});
