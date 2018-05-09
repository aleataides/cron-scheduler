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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});
Route::get('test', ['uses' => 'Admin\CronController@test', 'as' => 'test']);

Route::group(['middleware' => 'auth', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::group(['as' => 'dashboard.'], function () {
        Route::get('', ['uses' => 'Admin\IndexController@index', 'as' => 'index']);

    });

    Route::group(['prefix' => 'cron', 'as' => 'cron.'], function () {
        Route::get('', ['uses' => 'Admin\CronController@index', 'as' => 'index']);
        Route::get('create', ['uses' => 'Admin\CronController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'Admin\CronController@store', 'as' => 'store']);
        Route::post('destroy/{cron}', ['uses' => 'Admin\CronController@destroy', 'as' => 'destroy']);
    });
});

Route::group(['middleware' => ['auth', 'lock'], 'prefix' => 'lock', 'as' => 'lock.'], function () {
    Route::get('', ['uses' => 'Admin\LockController@index', 'as' => 'index']);
    Route::post('/lock', ['uses' => 'Admin\LockController@lock', 'as' => 'lock-screen']);
});

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/home', 'HomeController@index')->name('home');
