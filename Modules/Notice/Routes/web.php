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

Route::prefix('notice')->group(function() {
    Route::get('/', 'NoticeController@index')->name('notice.index');
    Route::get('create', 'NoticeController@create')->name('notice.create');
    Route::post('store', 'NoticeController@store')->name('notice.store');
    Route::get('{id}/edit', 'NoticeController@edit')->name('notice.edit');
    Route::put('{id}', 'NoticeController@update')->name('notice.update');
    Route::delete('{id}', 'NoticeController@destroy')->name('notice.destroy');
});
