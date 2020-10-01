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

//Route::middleware('auth:api')->get('/feedback', function (Request $request) {
//    return $request->user();
//});




$namespace = 'Modules\Feedback\Http\Controllers\API';

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => ['api.auth']], function ($api) use ($namespace) {

    // Pharmacy average rating
    $api->get('pharmacy/average-rating', $namespace . '\FeedbackController@pharmacyAverageRating');

    // Customer feedback store
    $api->post('feedback/store', $namespace . '\FeedbackController@store');

    // Feedback skipped by customer
    $api->put('feedback/{order_id}/skipped', $namespace . '\FeedbackController@feedbackSkipped');
});
