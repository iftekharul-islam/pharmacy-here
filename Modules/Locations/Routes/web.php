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

Route::prefix('locations')->group(function() {
    Route::get('/', 'LocationsController@index');
    Route::get('/districts', 'DistrictController@index')->name('districts');
    Route::get('districts/create', 'DistrictController@create')->name('district.create');
    Route::post('districts/store', 'DistrictController@store')->name('district.store');
    Route::get('districts/{id}/edit', 'DistrictController@edit')->name('district.edit');
    Route::put('districts/{id}', 'DistrictController@update')->name('district.update');
    Route::delete('districts/{id}', 'DistrictController@destroy')->name('district.destroy');
    
});
