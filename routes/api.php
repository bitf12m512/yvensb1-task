<?php

use Illuminate\Http\Request;
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

Route::group(['namespace' => 'Api'], function () {

    Route::post('/add-product', 'ApiController@addProduct')->name('addProduct.api');
    Route::post('/update-product/{id}', 'ApiController@updateProduct')->name('updateProduct.api');
    Route::delete('/delete-product/{id}', 'ApiController@updateProduct')->name('updateProduct.api');
    Route::get('/get-products', 'ApiController@getProducts')->name('getProducts.api');
    Route::get('/product/{id}', 'ApiController@getProduct')->name('getProduct.api');

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
