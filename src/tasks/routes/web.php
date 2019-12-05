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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/* インデックスページ*/
Route::get('/task', 'TaskController@index')->middleware('auth');

/** 新規追加 */
Route::get('/task/add', 'TaskController@add')->middleware('auth');
Route::post('/task/add', 'TaskController@create')->middleware('auth');

/** 編集 */
Route::get('/task/edit', 'TaskController@edit')->middleware('auth');
Route::post('/task/edit', 'TaskController@update')->middleware('auth');

/** 削除 */
Route::get('/task/del', 'TaskController@del')->middleware('auth');
Route::post('/task/del', 'TaskController@remove')->middleware('auth');

/** 完了 */
Route::get('/task/complete', 'TaskController@complete')->middleware('auth');

/** 検索 */
Route::post('/task/search', 'TaskController@search')->middleware('auth');
Route::get('/task/search', function () {
    return redirect('/task');
});