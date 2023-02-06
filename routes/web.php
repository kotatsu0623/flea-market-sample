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

Route::get("/", "PostController@index")->name('top');

Route::resource('items', 'PostController');

Route::get('/items/{item}/edit_image', 'PostController@editImage')->name('items.edit_image');

Route::patch('/items/{item}/edit_image', 'PostController@updateImage')->name('items.update_image');

Route::get('/items/{item}/confirm', 'PostController@confirm')->name('items.confirm');

Route::get('/items/{item}/purchase', 'PostController@purchase')->name('items.purchase');

Route::get('/users/edit', 'UserController@edit')->name('users.edit');

Route::patch('/users', 'UserController@update')->name('users.update');

Route::get('/users/edit_image', 'UserController@editImage')->name('users.edit_image');

Route::patch('/users/edit_image', 'UserController@updateImage')->name('users.update_image');

Route::get('/users/{user}/exhibitions', 'UserController@exhibitions')->name('users.exhibitions');

Route::resource('users', 'UserController')->only([
   'show',
]);

Route::resource('likes', 'LikeController')->only([
   'index',
]);

Route::patch('/items/{item}/toggle_like', 'PostController@toggleLike')->name('items.toggle_like');
