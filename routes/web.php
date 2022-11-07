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
    Route::get('/search', 'AccountController@search')->name('account.search');
    Route::get('/account/{account}', 'AccountController@showAccountPage')->name('account.showAccountPage');
    Route::get('/posts', 'PostController@showPosts');
    Route::get('/follow_follower', 'AccountController@showFollowAndFollower');
    Route::post('/charts', 'ChartController@store');
    Route::get('/charts/register_chart', 'ChartController@create');
    Route::get('/charts/registered_chart/{chart}', 'ChartController@showRegistered');
    Route::resource('account', 'AccountController')->only(['index', 'edit', 'update', 'search', 'showAccountPage']);
    Route::post('account/{account}/follow', 'AccountController@follow')->name('follow');
    Route::delete('account/{account}/unfollow', 'AccountController@unfollow')->name('unfollow');
    Route::resource('favorites', 'FavoritesController', ['only' => ['store', 'destroy']]);
    
});
Auth::routes();

