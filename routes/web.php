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
Route::get('/news', 'PostController@news');
Route::post('/charts', 'ChartController@store');
Route::get('/charts/register', 'ChartController@create');
Route::get('/charts/registered/{chart}', 'ChartController@show');
