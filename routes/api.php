<?php

use Illuminate\Http\Request;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization, X-Auth-Token');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS');


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

    Route::prefix('products')->group(function () {
        Route::get('/', 'ProductsController@index');
        Route::get('/inventory/count', 'ProductsController@count');
        Route::post('/inventory/add', 'ProductsController@create');
    });



    Route::prefix('bonanza')->group(function () {
        Route::get('/products', 'BonanzaExportController@index');
        Route::get('/products/count', 'BonanzaExportController@count');
    });

    Route::post('/categories/add', 'CategoriesController@create');
    Route::get('/categories/get', 'CategoriesController@setCategory');
    Route::post('/categories/set', 'CategoriesController@set');

    Route::post('/ebid_categories/add', 'EbidCategoriesController@create');
    Route::get('/ebid_categories/get', 'EbidCategoriesController@index');

    Route::post('/bonanza_categories/add', 'BonanzaCategoriesController@create');
    Route::get('/bonanza_categories/get', 'BonanzaCategoriesController@index');
});