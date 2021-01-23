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


    // Categories categories
    Route::get('categories/', 'AdminController@categories')->name('categories');
    Route::get ('dtcategories/', 'AdminController@dtcategories')->name('dtcategories');
    Route::post('savecategories/', 'AdminController@savecategories')->name('savecategories');
    Route::get('deletecategories/{id}', 'AdminController@deletecategories')->name('deletecategories');

});

Route::get('/home', 'HomeController@index')->name('home');
