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
    $api->group(['prefix' => 'products'], function ($api) use ($namespace) {
        $api->get('company', $namespace . '\CompanyController@index');
        $api->get('company/{id}', $namespace . '\CompanyController@show');

        $api->get('generic', $namespace . '\GenericController@index');
        $api->get('generic/{id}', $namespace . '\GenericController@show');

        $api->get('form', $namespace . '\FormController@index');
        $api->get('form/{id}', $namespace . '\FormController@show');
    });

    $api->group(['prefix' => 'products', 'middleware' => 'role:admin'], function ($api) use ($namespace) {
        $api->post('company', $namespace . '\CompanyController@store');
        $api->put('company/{id}', $namespace . '\CompanyController@update');
        $api->delete('company/{id}', $namespace . '\CompanyController@destroy');

        $api->post('generic', $namespace . '\GenericController@store');
        $api->put('generic/{id}', $namespace . '\GenericController@update');
        $api->delete('generic/{id}', $namespace . '\GenericController@destroy');

        $api->post('form', $namespace . '\FormController@store');
        $api->put('form/{id}', $namespace . '\FormController@update');
        $api->delete('form/{id}', $namespace . '\FormController@destroy');
    });
});
