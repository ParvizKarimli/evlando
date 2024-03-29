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
Route::get('posts/search', 'PostsController@search');
Route::get('posts/suspended', 'PostsController@suspended');
Route::get('posts/active', 'PostsController@active');
Route::resource('posts', 'PostsController');
Route::get('posts/{id}/{slug}', 'PostsController@show');
Route::post('posts/remove_cover_image', 'PostsController@remove_cover_image');
Route::post('posts/remove_image', 'PostsController@remove_image');
Route::post('posts/get_location_suggestions', 'PostsController@get_location_suggestions');
Route::post('posts/suspend', 'PostsController@suspend');
Route::get('bookmarks/sale', 'BookmarksController@sale');
Route::get('bookmarks/rent', 'BookmarksController@rent');
Route::resource('bookmarks', 'BookmarksController');
Route::post('bookmarks/bookmark', 'BookmarksController@bookmark');
Route::get('users/banned', 'UsersController@banned');
Route::get('users/active', 'UsersController@active');
Route::resource('users', 'UsersController');
Route::post('users/ban', 'UsersController@ban');
Route::get('reports/get', 'ReportsController@get');
Route::resource('reports', 'ReportsController');
Route::post('/languages/set', 'LanguagesController@set');
