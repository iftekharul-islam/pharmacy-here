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
        $api->get('companies', $namespace . '\CompanyController@index');
        $api->get('companies/{id}', $namespace . '\CompanyController@show');

        $api->get('generics', $namespace . '\GenericController@index');
        $api->get('generics/{id}', $namespace . '\GenericController@show');

        $api->get('forms', $namespace . '\FormController@index');
        $api->get('forms/{id}', $namespace . '\FormController@show');

        $api->get('products', $namespace . '\ProductsController@index');
        $api->get('products/search', $namespace . '\ProductsController@search');
        $api->get('products/{id}', $namespace . '\ProductsController@show');

        $api->get('categories', $namespace . '\CategoryController@index');
        $api->get('categories/{id}', $namespace . '\CategoryController@show');
        $api->get('categories/slug/{slug}', $namespace . '\CategoryController@showBySlug');

        $api->get('units', $namespace . '\UnitController@index');
        $api->get('units/{id}', $namespace . '\UnitController@show');
        $api->get('units/slug/{slug}', $namespace . '\UnitController@showBySlug');

    $api->get('products/{id}/related-products', $namespace . '\ProductsController@getRelatedProductByProductId');


//    $api->group(['prefix' => 'products', 'middleware' => 'role:admin'], function ($api) use ($namespace) {
        $api->post('companies', $namespace . '\CompanyController@store');
        $api->put('companies/{id}', $namespace . '\CompanyController@update');
        $api->delete('companies/{id}', $namespace . '\CompanyController@destroy');

        $api->post('generics', $namespace . '\GenericController@store');
        $api->put('generics/{id}', $namespace . '\GenericController@update');
        $api->delete('generics/{id}', $namespace . '\GenericController@destroy');

        $api->post('forms', $namespace . '\FormController@store');
        $api->put('forms/{id}', $namespace . '\FormController@update');
        $api->delete('forms/{id}', $namespace . '\FormController@destroy');

        $api->post('products', $namespace . '\ProductsController@store');
        $api->put('products/{id}', $namespace . '\ProductsController@update');
        $api->delete('products/{id}', $namespace . '\ProductsController@destroy');

        $api->post('categories', $namespace . '\CategoryController@store');
        $api->put('categories/{id}', $namespace . '\CategoryController@update');
        $api->delete('categories/{id}', $namespace . '\CategoryController@destroy');

        $api->post('units', $namespace . '\UnitController@store');
        $api->put('units/{id}', $namespace . '\UnitController@update');
        $api->delete('units/{id}', $namespace . '\UnitController@destroy');

//    });

    $api->group(['middleware' => 'role:customer'], function ($api) use ($namespace) {
//        $api->get('carts', $namespace . '\CartController@index');
//        $api->post('carts', $namespace . '\CartController@store');
//
//        $api->put('cart-items/{id}', $namespace . '\CartController@updateCartItem');

//        $api->get('products/{id}/related_product', $namespace . '\ProductsController@getRelatedProductByProductId');
    });
});
