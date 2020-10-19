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

//Route::middleware('auth:api')->get('/alarm', function (Request $request) {
//    return $request->user();
//});



$namespace = 'Modules\Alarm\Http\Controllers\API';

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => ['api.auth']], function ($api) use ($namespace) {

    $api->get('alarm', $namespace . '\FeedbackController@pharmacyAverageRating');
    $api->post('alarm/store', $namespace . '\FeedbackController@store');
    $api->put('alarm/{alarm_id}', $namespace . '\FeedbackController@update');
    $api->delete('alarm/{alarm_id}', $namespace . '\FeedbackController@delete');

});

$reminderNamespace = 'Modules\Alarm\Http\Controllers\API';

$api->version('v1', ['middleware' => ['api.auth']], function ($api) use ($reminderNamespace) {

    $api->get('reminder', $reminderNamespace . '\AlarmController@index');
    $api->post('reminder/store', $reminderNamespace . '\AlarmController@store');
    $api->put('reminder/{reminder_id}', $reminderNamespace . '\AlarmController@update');
    $api->delete('reminder/{reminder_id}', $reminderNamespace . '\AlarmController@delete');
});
