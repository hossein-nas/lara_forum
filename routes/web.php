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


// threads related
Route::get('/home', 'HomeController@index');
Route::get('/threads', 'ThreadsController@index')->name('threads');
Route::get('/threads/create', 'ThreadsController@create');
Route::get('/threads/search', 'SearchThreadsController@index');
Route::get('/threads/{channel}', 'ThreadsController@index');
Route::post('/threads', 'ThreadsController@store')->middleware('must-be-confirmed');
Route::post('/threads/{thread}/lock', "LockThreadsController@store")->name('lock-threads.store')->middleware('admin');
Route::delete('/threads/{thread}/lock', "LockThreadsController@destroy")->name('lock-threads.destroy')->middleware('admin');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
Route::patch('/threads/{channel}/{thread}', 'ThreadsController@update')->name('threads.update');
Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy');


// subscriptions
Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy');

Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');
Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index');

Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');
Route::delete('/replies/{reply}', 'RepliesController@destory')->name('replies.destroy');
Route::patch('/replies/{reply}', 'RepliesController@update');
Route::post('/replies/{reply}/best', 'BestRepliesController@store')->name('best-replies.store');

Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');

Route::delete('profiles/{user}/notifications/{notification}', 'UsersNotificationsController@destroy');
Route::get('profiles/{user}/notifications/', 'UsersNotificationsController@index');

Route::get('/register/confirm', 'Auth\RegisterConfirmationController@index')->name('register.confirm');

Route::get('/api/users', 'Api\UsersController@index');
Route::post('/api/users/{user}/avatar', 'Api\UserAvatarController@store')->middleware('auth')->name('avatar');
