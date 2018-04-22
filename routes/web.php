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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/item/{id}', 'HomeController@item');
Route::get('/users','AjaxController@users');
Route::get('/profile/{id}','HomeController@profile');
Route::get('/additem','HomeController@additem')->middleware('auth');
Route::post('/saveimage','HomeController@saveImage');
