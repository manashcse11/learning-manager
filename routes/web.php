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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
Route::get('/progress', 'ProgressController@index')->name('progress');
Route::get('/category/{id}', 'CategoryController@show')->name('category');
Route::get('/item/{id}', 'ItemController@show')->name('item');
Route::post('/item/add', 'ItemController@store')->name('itemadd');
Route::post('/item/sort', 'ItemController@sort')->name('itemsort');
