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

Route::prefix('delivery')->group(function() {
//    Route::get('/', 'DeliveryController@index');
    Route::get('normal-delivery', 'DeliveryTimeController@normalDeliveryList')->name('normal-delivery-time');
    Route::get('express-delivery', 'DeliveryTimeController@expressDeliveryList')->name('express-delivery-time');
    Route::get('delivery-time/create', 'DeliveryTimeController@create')->name('delivery-time-create');
    Route::post('delivery-time/store', 'DeliveryTimeController@store')->name('delivery-time-store');
    Route::get('delivery-time/{id}/edit', 'DeliveryTimeController@edit')->name('delivery-time-edit');
    Route::put('delivery-time/{id}/edit', 'DeliveryTimeController@update')->name('delivery-time-update');
    Route::delete('delivery-time/{id}/destroy', 'DeliveryTimeController@destroy')->name('delivery-time-destroy');
});
