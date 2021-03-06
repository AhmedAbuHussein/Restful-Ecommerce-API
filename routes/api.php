<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//api route

Route::middleware('jwt')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix'=>'auth'
],function(){
    Route::post('login','AuthController@login');
    Route::post('logout','AuthController@logout');
    Route::post('refresh','AuthController@refresh');
    Route::post('me','AuthController@me');
    Route::post('payload','AuthController@payload');
});

Route::apiResource('products','ProductController');

Route::group([
    'prefix'=>'products'
],function(){
    Route::apiResource('/{product}/reviews','ReviewController');
});