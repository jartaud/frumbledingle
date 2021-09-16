<?php

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

Route::resource('locations', 'Api\LocationController', ['only' => ['index', 'store', 'destroy']]);
Route::resource('items', 'Api\ItemController', ['only' => ['index', 'store', 'destroy']]);
Route::resource('categories', 'Api\CategoryController', ['only' => ['index', 'store', 'destroy']]);
Route::resource('report', 'Api\ReportController', ['only' => ['index', ]]);
