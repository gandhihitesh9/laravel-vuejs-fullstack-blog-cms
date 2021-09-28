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

/** Tags Routes */
Route::post("app/tag/create", "App\Http\Controllers\TagController@create");
Route::get("app/tag/index", "App\Http\Controllers\TagController@index");
Route::post("app/tag/edit", "App\Http\Controllers\TagController@store");
Route::post("app/tag/delete", "App\Http\Controllers\TagController@destroy");

/** Categories Routes */
Route::post("app/category/create", "App\Http\Controllers\CategoriesController@create");
Route::get("app/category/index", "App\Http\Controllers\CategoriesController@index");
Route::post("app/category/edit", "App\Http\Controllers\CategoriesController@store");

Route::get('/', function () {
    return view('welcome');
});
Route::any('{slug}', function () {
    return view('welcome');
});

