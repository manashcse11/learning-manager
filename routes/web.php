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
Route::get('/instruction', 'InstructionController@index')->name('how');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
Route::get('/progress', 'ProgressController@index')->name('progress');
Route::get('/progress/{id}', 'ProgressController@show')->name('progressIndividual');
Route::get('/categories', 'CategoryController@index')->name('category_all');
Route::get('/category/{id}', 'CategoryController@show')->name('category');
Route::get('/item/{id}', 'ItemController@show')->name('item');
Route::post('/item/add', 'ItemController@store')->name('itemadd');
Route::post('/item/{id}/update', 'ItemController@update')->name('itemupdate');
Route::get('/subcategories', 'ItemController@subcategories')->name('subcategories');
Route::post('/subcategories/add', 'ItemController@storeSubCategory')->name('addsubcategory');
Route::post('/item/sort', 'ItemController@sort')->name('itemsort');
