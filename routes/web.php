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

// Route::get('/', function () {
//     return view('welcome');
// });

//我们向 http://weibo.test/ 发出了一个请求，
//则该请求将会由 StaticPagesController 的 home 方法进行处理
//http://weibo.test
Route::get('/', 'StaticPagesController@home')->name('home');
//http://weibo.test/help
Route::get('/help', 'StaticPagesController@help')->name('help');
//http://weibo.test/about
Route::get('/about', 'StaticPagesController@about')->name('about');
