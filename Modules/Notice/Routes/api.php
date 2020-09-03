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

$namespace = 'Modules\Notice\Http\Controllers\API';


$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) use ($namespace) {
    $api->get('pharmacy/notice', $namespace . '\NoticeController@latestPharmacyNotice');
    $api->get('customer/notice', $namespace . '\NoticeController@latestCustomerNotice');

    $api->post('notice', $namespace . '\NoticeController@store');


});
