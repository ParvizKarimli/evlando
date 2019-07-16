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

Route::get('/', 'PagesController@index');
Route::get('about', 'PagesController@about');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::resource('posts', 'PostsController');
Route::post('posts/remove_cover_image', 'PostsController@remove_cover_image');
Route::post('posts/remove_image', 'PostsController@remove_image');
Route::resource('posts', 'PostsController');
