<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::prefix('orders')->group(function() {
//    Route::get('orders', 'OrdersController@index');
//});

Route::get('orders', 'OrdersController@index')->name('orders.index');
Route::get('orders/{order_id}', 'OrdersController@show')->name('orders.show');

Route::get('transaction-history', 'TransactionHistoryController@index')->name('transactionHistory.index');
Route::get('transaction/create/{trans_id}', 'TransactionHistoryController@create')->name('transactionHistory.create');
Route::get('transaction-history/{trans_id}', 'TransactionHistoryController@show')->name('transactionHistory.show');
Route::post('transaction', 'TransactionHistoryController@store')->name('transactionHistory.store');

//Route::get('transaction-history', function (){
//    return 'Hello controller';
//});
