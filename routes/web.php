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

Route::group(['middleware' => ['auth']], function(){
    Route::get('/', 'AccountController@index');
    Route::post('/', 'PostController@store');
    Route::delete('delete/{chart}', 'PostController@delete')->name('delete');
    Route::get('/posts', 'PostController@showPosts');
    //Route::get('/account/{account}', 'AccountController@showAccountPage');
    Route::post('/charts', 'ChartController@store');
    Route::get('/charts/register_chart', 'ChartController@create');
    Route::get('/charts/registered_chart/{chart}', 'ChartController@showRegistered');
    Route::resource('account', 'AccountController')->only(['index', 'edit', 'update']);
    
});
Auth::routes();

