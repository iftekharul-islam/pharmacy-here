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

$namespace = 'Modules\Products\Http\Controllers\API';


$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) use ($namespace) {
    $api->group(['prefix' => 'products', 'middleware' => 'role:admin'], function ($api) use ($namespace) {
//        $api->get('company', $namespace . '\ProductsController@companyList');
    });

    $api->group(['prefix' => 'products', 'middleware' => 'role:admin'], function ($api) use ($namespace) {
        $api->resource('company', $namespace . '\CompanyController');
        $api->resource('generic', $namespace . '\GenericController');
    });
});
