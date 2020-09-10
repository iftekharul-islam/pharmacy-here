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


//Route::get('/', function() {
//    return redirect()->route('login');
//});


//Route::get('/login', 'HomeController@login');


Route::get('/', 'HomeController@index')->name('home');

Route::get('/product',  'ProductsController@index')->name('product-list');
Route::get('/product/{product_id}',  'ProductsController@show')->name('single-product');
//Route::get('/product',  '\Modules\Products\Http\Controllers\API\ProductsController@index')->name('product');

