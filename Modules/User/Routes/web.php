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


Route::group(['middleware' => ['web','role:admin']], function () {

//    Route::get('home','HomeController@index');

    Route::prefix('user')->group(function() {
        Route::get('/dashboard', 'UserController@index')->name('user.dashboard');
    });

    Route::prefix('customers')->group(function() {
        Route::get('/', 'CustomerController@index')->name('customer.index');
        Route::get('show/{id}', 'CustomerController@show')->name('customer.show');
        Route::get('edit/{id}', 'CustomerController@edit')->name('customer.edit');
        Route::post('store/{id}', 'CustomerController@update')->name('customer.store');
        Route::delete('{id}', 'CustomerController@destroy')->name('customer.destroy');
    });


    Route::get('bank', 'BankController@index')->name('bank.index');
    Route::get('bank/create', 'BankController@create')->name('bank.create');
    Route::post('bank', 'BankController@store')->name('bank.store');
    Route::get('bank/{id}', 'BankController@show')->name('bank.show');
    Route::get('bank/{id}/edit', 'BankController@edit')->name('bank.edit');
    Route::put('bank/{id}', 'BankController@update')->name('bank.update');
    Route::delete('bank/{id}', 'BankController@destroy')->name('bank.destroy');

});


