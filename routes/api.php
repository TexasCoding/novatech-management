<?php

use Illuminate\Http\Request;

// /*
// |--------------------------------------------------------------------------
// | API Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register API routes for your application. These
// | routes are loaded by the RouteServiceProvider within a group which
// | is assigned the "api" middleware group. Enjoy building your API!
// |
// */

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::namespace('Api')->group(function () {
    Route::get('/users', 'UsersController@index');
    Route::get('/products/inventory/count', 'ProductsController@count');
    Route::post('/products/inventory/add', 'ProductsController@create');

    Route::post('/categories/add', 'CategoriesController@create');
    Route::get('/categories/get', 'CategoriesController@setCategory');
    Route::post('/categories/set', 'CategoriesController@set');

    Route::post('/ebid_categories/add', 'EbidCategoriesController@create');
    Route::get('/ebid_categories/get', 'EbidCategoriesController@index');

    Route::post('/bonanza_categories/add', 'BonanzaCategoriesController@create');
    Route::get('/bonanza_categories/get', 'BonanzaCategoriesController@index');
});