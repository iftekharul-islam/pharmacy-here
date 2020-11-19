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

Route::group(["middleware" => ["web", "role:admin"]], function() {

    Route::post('products/import', 'ProductsController@importCsv')->name('import-csv');

    Route::get('products', 'ProductsController@index')->name('index');
    Route::get('products/create', 'ProductsController@create')->name('create');
    Route::post('products/store', 'ProductsController@store')->name('store');
    Route::get('products/{id}/edit', 'ProductsController@edit')->name('edit');
    Route::put('products/{id}', 'ProductsController@update')->name('update');
    Route::delete('products/{id}', 'ProductsController@destroy')->name('destroy');
//    Route::resource('products','ProductsController');

//    Route::resource('companies', 'CompanyController');
    Route::get('companies', 'CompanyController@index')->name('company.index');
    Route::get('companies/create', 'CompanyController@create')->name('company.create');
    Route::post('companies/store', 'CompanyController@store')->name('company.store');
    Route::get('companies/{id}/edit', 'CompanyController@edit')->name('company.edit');
    Route::put('companies/{id}', 'CompanyController@update')->name('company.update');
    Route::delete('companies/{id}', 'CompanyController@destroy')->name('company.destroy');

//    Route::resource('categories', 'CategoryController');
    Route::get('categories', 'CategoryController@index')->name('category.index');
    Route::get('categories/create', 'CategoryController@create')->name('category.create');
    Route::post('categories/store', 'CategoryController@store')->name('category.store');
    Route::get('categories/{id}/edit', 'CategoryController@edit')->name('category.edit');
    Route::put('categories/{id}', 'CategoryController@update')->name('category.update');
    Route::delete('categories/{id}', 'CategoryController@destroy')->name('category.destroy');

//    Route::resource('forms', 'FormController');
    Route::get('forms', 'FormController@index')->name('form.index');
    Route::get('forms/create', 'FormController@create')->name('form.create');
    Route::post('forms/store', 'FormController@store')->name('form.store');
    Route::get('forms/{id}/edit', 'FormController@edit')->name('form.edit');
    Route::put('forms/{id}', 'FormController@update')->name('form.update');
    Route::delete('forms/{id}', 'FormController@destroy')->name('form.destroy');

//    Route::resource('generics', 'GenericController');
    Route::get('generics', 'GenericController@index')->name('generic.index');
    Route::get('generics/create', 'GenericController@create')->name('generic.create');
    Route::post('generics/store', 'GenericController@store')->name('generic.store');
    Route::get('generics/{id}/edit', 'GenericController@edit')->name('generic.edit');
    Route::put('generics/{id}', 'GenericController@update')->name('generic.update');
    Route::delete('generics/{id}', 'GenericController@destroy')->name('generic.destroy');

    //Route::resource('units', 'UnitController');
    Route::get('units', 'UnitController@index')->name('unit.index');
    Route::get('units/create', 'UnitController@create')->name('unit.create');
    Route::post('units/store', 'UnitController@store')->name('unit.store');
    Route::get('units/{id}/edit', 'UnitController@edit')->name('unit.edit');
    Route::put('units/{id}', 'UnitController@update')->name('unit.update');
    Route::delete('units/{id}', 'UnitController@destroy')->name('unit.destroy');

    // pharmacy route
    Route::get('pharmacies', 'PharmacyController@index')->name('pharmacy.index');
    Route::get('pharmacies/create/{user_id}', 'PharmacyController@create')->name('pharmacy.create');
    Route::post('pharmacies/store', 'PharmacyController@store')->name('pharmacy.store');
    Route::get('pharmacies/{id}/edit', 'PharmacyController@edit')->name('pharmacy.edit');
    Route::put('pharmacies/{id}', 'PharmacyController@update')->name('pharmacy.update');
    Route::delete('pharmacies/{id}', 'PharmacyController@destroy')->name('pharmacy.destroy');
    Route::delete('search-pharmacy', 'PharmacyController@search')->name('pharmacy-search');

});
