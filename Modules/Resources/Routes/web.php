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

Route::prefix('resources')->group(function() {
    Route::get('/', 'ResourcesController@index')->name('index');

    Route::get('create', 'ResourcesController@create')->name('create');
    Route::post('store', 'ResourcesController@store')->name('store');
    Route::get('{id}/edit', 'ResourcesController@edit')->name('edit');
    Route::put('{id}', 'ResourcesController@update')->name('update');
    Route::delete('{id}', 'ResourcesController@destroy')->name('destroy');
});
