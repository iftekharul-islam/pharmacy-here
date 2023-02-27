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



$namespace = 'Modules\Alarm\Http\Controllers\API';

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => ['api.auth']], function ($api) use ($namespace) {

    $api->get('alarm', $namespace . '\AlarmController@index');
    $api->post('alarm/store', $namespace . '\AlarmController@store');
    $api->put('alarm/{alarm_id}', $namespace . '\AlarmController@update');
    $api->delete('alarm/{alarm_id}', $namespace . '\AlarmController@delete');

    $api->get('reminder', $namespace . '\ReminderController@index');
    $api->post('reminder/store', $namespace . '\ReminderController@store');
    $api->put('reminder/{reminder_id}', $namespace . '\ReminderController@update');
    $api->delete('reminder/{reminder_id}', $namespace . '\ReminderController@delete');

});

//$reminderNamespace = 'Modules\Alarm\Http\Controllers\API';
//
//$api->version('v1', ['middleware' => ['api.auth']], function ($api) use ($reminderNamespace) {
//
//    $api->get('reminder', $reminderNamespace . '\ReminderController@index');
//    $api->post('reminder/store', $reminderNamespace . '\ReminderController@store');
//    $api->put('reminder/{reminder_id}', $reminderNamespace . '\ReminderController@update');
//    $api->delete('reminder/{reminder_id}', $reminderNamespace . '\ReminderController@delete');
//});
