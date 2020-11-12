<?php

use Illuminate\Support\Facades\Route;
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
Route::group(["middleware" => ["web", "role:admin"]], function() {
    Route::get('orders', 'OrdersController@index')->name('orders.index');
    Route::get('export-orders', 'OrdersController@exportOrder')->name('export.orders');
    Route::get('orders/{order_id}', 'OrdersController@show')->name('orders.show');

    Route::get('transaction-history', 'TransactionHistoryController@index')->name('transactionHistory.index');
    Route::get('export-pharmacy-transaction/district/thana/area', 'TransactionHistoryController@exportPharmacyTransaction')->name('epay.export.transaction');
    Route::get('export-pharmacy-transaction-history/to-date/form-date/user-id', 'TransactionHistoryController@exportPharmacyTransactionById')->name('epay.export.transaction.history');
    Route::get('cod-export-pharmacy-transaction/district/thana/area', 'TransactionHistoryController@codExportPharmacyTransaction')->name('cod.export.transaction');
    Route::get('cod-export-pharmacy-transaction-history/to-date/form-date/user-id', 'TransactionHistoryController@codExportPharmacyTransactionById')->name('cod.export.transaction.history');
    Route::get('transaction/create/{trans_id}', 'TransactionHistoryController@create')->name('transactionHistory.create');
    Route::get('transaction-history/{trans_id}', 'TransactionHistoryController@show')->name('transactionHistory.show');
    Route::post('transaction', 'TransactionHistoryController@store')->name('transactionHistory.store');

    Route::get('cod-transaction-history', 'TransactionHistoryController@cod')->name('cod.transactionHistory.index');
    Route::get('cod-transaction-history/{trans_id}', 'TransactionHistoryController@codShow')->name('cod.transactionHistory.show');
});
