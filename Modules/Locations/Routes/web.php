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

    Route::get('/divisions', 'DistrictController@index')->name('divisions');
    Route::get('divisions/create', 'DistrictController@create')->name('division.create');
    Route::post('divisions/store', 'DistrictController@store')->name('division.store');
    Route::get('divisions/{id}/edit', 'DistrictController@edit')->name('division.edit');
    Route::put('divisions/{id}', 'DistrictController@update')->name('division.update');
    Route::delete('divisions/{id}', 'DistrictController@destroy')->name('division.destroy');

    Route::get('/districts', 'DistrictController@index')->name('districts');
    Route::get('districts/create', 'DistrictController@create')->name('district.create');
    Route::post('districts/store', 'DistrictController@store')->name('district.store');
    Route::get('districts/{id}/edit', 'DistrictController@edit')->name('district.edit');
    Route::put('districts/{id}', 'DistrictController@update')->name('district.update');
    Route::delete('districts/{id}', 'DistrictController@destroy')->name('district.destroy');

    Route::get('/thana', 'ThanaController@index')->name('thana');
    Route::get('thana/create', 'ThanaController@create')->name('thana.create');
    Route::post('thana/store', 'ThanaController@store')->name('thana.store');
    Route::get('thana/{id}/edit', 'ThanaController@edit')->name('thana.edit');
    Route::put('thana/{id}', 'ThanaController@update')->name('thana.update');
    Route::delete('thana/{id}', 'ThanaController@destroy')->name('thana.destroy');
    
});
