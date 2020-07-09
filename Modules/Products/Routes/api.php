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

//Route::middleware('auth:api')->get('/products', function (Request $request) {
//    return $request->user();
//});

$namespace = 'Modules\Products\Http\Controllers\API';


$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) use ($namespace){
    $api->group(['prefix' => 'products'], function ($api) use ($namespace) {
        $api->get('company', $namespace . '\ProductsController@companyList');
    });
});
