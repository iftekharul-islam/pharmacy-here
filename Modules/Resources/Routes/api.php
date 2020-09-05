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



$namespace = 'Modules\Resources\Http\Controllers\API';


$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) use ($namespace) {
    $api->get('resources', $namespace . '\ResourceController@index');
    $api->post('resources', $namespace . '\ResourceController@store');

});
