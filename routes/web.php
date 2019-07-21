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
Route::get('posts/sale', 'PostsController@sale');
Route::get('posts/rent', 'PostsController@rent');
Route::get('posts/search', 'PostsController@search');
Route::resource('posts', 'PostsController');
Route::post('posts/remove_cover_image', 'PostsController@remove_cover_image');
Route::post('posts/remove_image', 'PostsController@remove_image');
Route::post('posts/get_location_suggestions', 'PostsController@get_location_suggestions');
Route::get('bookmarks/sale', 'BookmarksController@sale');
Route::get('bookmarks/rent', 'BookmarksController@rent');
Route::resource('bookmarks', 'BookmarksController');
Route::post('bookmarks/bookmark', 'BookmarksController@bookmark');
