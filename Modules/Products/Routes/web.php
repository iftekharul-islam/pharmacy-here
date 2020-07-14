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

Route::prefix('products')->group(function() {
    Route::get('/', 'ProductsController@index')->name('index');
    Route::get('create', 'ProductsController@create')->name('create');
    Route::post('store', 'ProductsController@store')->name('store');
    Route::get('{id}/edit', 'ProductsController@edit')->name('edit');
    Route::put('{id}', 'ProductsController@update')->name('update');
    Route::delete('{id}', 'ProductsController@destroy')->name('destroy');
//    Route::resource('/','ProductsController');

//    Route::resource('company', 'CompanyController');
    Route::get('company', 'CompanyController@index')->name('company.index');
    Route::get('company/create', 'CompanyController@create')->name('company.create');
    Route::post('company/store', 'CompanyController@store')->name('company.store');
    Route::get('company/{id}/edit', 'CompanyController@edit')->name('company.edit');
    Route::put('company/{id}', 'CompanyController@update')->name('company.update');
    Route::delete('company/{id}', 'CompanyController@destroy')->name('company.destroy');

//    Route::resource('category', 'CategoryController');
    Route::get('category', 'CategoryController@index')->name('category.index');
    Route::get('category/create', 'CategoryController@create')->name('category.create');
    Route::post('category/store', 'CategoryController@store')->name('category.store');
    Route::get('category/{id}/edit', 'CategoryController@edit')->name('category.edit');
    Route::put('category/{id}', 'CategoryController@update')->name('category.update');
    Route::delete('category/{id}', 'CategoryController@destroy')->name('category.destroy');

//    Route::resource('form', 'FormController');
    Route::get('form', 'FormController@index')->name('form.index');
    Route::get('form/create', 'FormController@create')->name('form.create');
    Route::post('form/store', 'FormController@store')->name('form.store');
    Route::get('form/{id}/edit', 'FormController@edit')->name('form.edit');
    Route::put('form/{id}', 'FormController@update')->name('form.update');
    Route::delete('form/{id}', 'FormController@destroy')->name('form.destroy');

//    Route::resource('generic', 'GenericController');
    Route::get('generic', 'GenericController@index')->name('generic.index');
    Route::get('generic/create', 'GenericController@create')->name('generic.create');
    Route::post('generic/store', 'GenericController@store')->name('generic.store');
    Route::get('generic/{id}/edit', 'GenericController@edit')->name('generic.edit');
    Route::put('generic/{id}', 'GenericController@update')->name('generic.update');
    Route::delete('generic/{id}', 'GenericController@destroy')->name('generic.destroy');

//    Route::resource('unit', 'UnitController');
    Route::get('unit', 'UnitController@index')->name('unit.index');
    Route::get('unit/create', 'UnitController@create')->name('unit.create');
    Route::post('unit/store', 'UnitController@store')->name('unit.store');
    Route::get('unit/{id}/edit', 'UnitController@edit')->name('unit.edit');
    Route::put('unit/{id}', 'UnitController@update')->name('unit.update');
    Route::delete('unit/{id}', 'UnitController@destroy')->name('unit.destroy');
});
