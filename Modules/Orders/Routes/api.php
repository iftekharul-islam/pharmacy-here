<?php

use Aws\Middleware;
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

$namespace = 'Modules\Orders\Http\Controllers\API';


$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) use ($namespace) {
    //payment
    $api->get('payment', $namespace . '\PaymentController@payment');
    $api->post('payment/success', $namespace . '\PaymentController@paymentSuccess');
    $api->post('payment/failed', $namespace . '\PaymentController@paymentFailed');
    $api->post('payment/cancel', $namespace . '\PaymentController@paymentCancel');


});

$api->version('v1', function ($api) use ($namespace) {
    $api->get('orders', $namespace . '\OrderController@index');
    $api->get('orders/customer', $namespace . '\OrderController@getCustomerOrders');
    $api->get('orders/{order_id}', $namespace . '\OrderController@show');
    $api->post('orders/create', $namespace . '\OrderController@create');
    $api->get('pharmacy/orders', $namespace . '\OrderController@ordersByPharmacyId');
    $api->get('customer/orders', $namespace . '\OrderController@ordersByCustomerId');

    //pharmacy order list by status
    $api->get('pharmacy/orders/{status_id}', $namespace . '\OrderController@pharmacyOrdersByStatus');

    //order status update
    $api->put('orders/{order_id}/status/{status_id}', $namespace . '\OrderController@ordersStatusUpdate');
    $api->post('delivery/charge', $namespace . '\DeliveryChargeController@index');

    //pharmacy order cancel reason
    $api->post('orders/cancel-reason', $namespace . '\OrderController@pharmacyOrderCancelReason');

    // Pharmacy Transaction history
    $api->get('pharmacy/transaction-amount', $namespace . '\TransactionHistoryController@getPharmacyTransactionAmount');
    $api->get('pharmacy/transaction-history', $namespace . '\TransactionHistoryController@getPharmacyTransaction');
    $api->post('pharmacy/transaction', $namespace . '\TransactionHistoryController@storePharmacyTransaction');

    // Pharmacy Sales history
    $api->get('pharmacy/sales-history', $namespace . '\TransactionHistoryController@pharmacySalesHistory');

    // Pharmacy total sale
    $api->get('pharmacy/total-sale', $namespace . '\TransactionHistoryController@pharmacyTotalSale');

    //Pharmacy
    $api->get('pharmacy/total-received', $namespace . '\TransactionHistoryController@pharmacyTotalReceived');

});
