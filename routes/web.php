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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function(){
    Route::get('/', function () {
        return view('admin.index');
    });
    Route::get('/users', function () {
        return view('admin.users');
    });

    // Users users
    Route::get('users/', 'AdminController@users')->name('users');
    Route::get ('dtusers/', 'AdminController@dtusers')->name('dtusers');
    Route::post('saveusers/', 'AdminController@saveusers')->name('saveusers');
    // Route::get('deletecategories/{id}', 'AdminController@deletecategories')->name('deletecategories');

    // Categories categories
    Route::get('categories/', 'AdminController@categories')->name('categories');
    Route::get ('dtcategories/', 'AdminController@dtcategories')->name('dtcategories');
    Route::post('savecategories/', 'AdminController@savecategories')->name('savecategories');
    Route::get('deletecategories/{id}', 'AdminController@deletecategories')->name('deletecategories');

    // Products products
    Route::get('products/', 'AdminController@products')->name('products');
    Route::get ('dtproducts/', 'AdminController@dtproducts')->name('dtproducts');
    Route::post('saveproducts/', 'AdminController@saveproducts')->name('saveproducts');
    Route::get('deleteproducts/{id}', 'AdminController@deleteproducts')->name('deleteproducts');

    // Promotions promotions
    Route::get('promotions/', 'AdminController@promotions')->name('promotions');
    Route::get ('dtpromotions/', 'AdminController@dtpromotions')->name('dtpromotions');
    Route::post('savepromotions/', 'AdminController@savepromotions')->name('savepromotions');
    Route::get('deletepromotions/{id}', 'AdminController@deletepromotions')->name('deletepromotions');
});

Route::get('/home', 'HomeController@index')->name('home');
