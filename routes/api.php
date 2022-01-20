<?php

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/actions', 'App\Http\Controllers\ActionController@getActions');
Route::get('/search', 'App\Http\Controllers\AnalysesController@search');
Route::post('/cart', 'App\Http\Controllers\CartController@get');
Route::post('/register', 'App\Http\Controllers\AuthController@registration');
Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::middleware('auth:api')->delete('/logout', 'App\Http\Controllers\AuthController@logout');
Route::middleware('auth:api')->post('/order/create', 'App\Http\Controllers\OrderController@create');
Route::middleware('auth:api')->get('/order/get/{orderId}', 'App\Http\Controllers\OrderController@getOrderInfo');
Route::middleware('auth:api')->delete('/order/delete/{orderId}', 'App\Http\Controllers\OrderController@delete');
Route::middleware('auth:api')->get('/order/search', 'App\Http\Controllers\OrderController@search');