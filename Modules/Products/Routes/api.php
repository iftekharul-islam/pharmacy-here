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
        $api->get('category', $namespace . '\CompanyController@index');
        $api->get('category/{id}', $namespace . '\CompanyController@show');

        $api->get('generic', $namespace . '\GenericController@index');
        $api->get('generic/{id}', $namespace . '\GenericController@show');

        $api->get('form', $namespace . '\FormController@index');
        $api->get('form/{id}', $namespace . '\FormController@show');

        $api->get('products', $namespace . '\ProductsController@index');
        $api->get('products/{id}', $namespace . '\ProductsController@show');

        $api->get('categories', $namespace . '\CategoryController@index');
        $api->get('categories/{id}', $namespace . '\CategoryController@show');
        $api->get('categories/slug/{slug}', $namespace . '\CategoryController@showBySlug');

        $api->get('units', $namespace . '\UnitController@index');
        $api->get('units/{id}', $namespace . '\UnitController@show');
        $api->get('units/slug/{slug}', $namespace . '\UnitController@showBySlug');
    });

    $api->group(['prefix' => 'products', 'middleware' => 'role:admin'], function ($api) use ($namespace) {
        $api->post('category', $namespace . '\CompanyController@store');
        $api->put('category/{id}', $namespace . '\CompanyController@update');
        $api->delete('category/{id}', $namespace . '\CompanyController@destroy');

        $api->post('generic', $namespace . '\GenericController@store');
        $api->put('generic/{id}', $namespace . '\GenericController@update');
        $api->delete('generic/{id}', $namespace . '\GenericController@destroy');

        $api->post('form', $namespace . '\FormController@store');
        $api->put('form/{id}', $namespace . '\FormController@update');
        $api->delete('form/{id}', $namespace . '\FormController@destroy');

        $api->post('products', $namespace . '\ProductsController@store');
        $api->put('products/{id}', $namespace . '\ProductsController@update');
        $api->delete('products/{id}', $namespace . '\ProductsController@destroy');

        $api->post('categories', $namespace . '\CategoryController@store');
        $api->put('categories/{id}', $namespace . '\CategoryController@update');
        $api->delete('categories/{id}', $namespace . '\CategoryController@destroy');

        $api->post('units', $namespace . '\UnitController@store');
        $api->put('units/{id}', $namespace . '\UnitController@update');
        $api->delete('units/{id}', $namespace . '\UnitController@destroy');

    });
});
