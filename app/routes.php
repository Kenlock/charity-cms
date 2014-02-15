<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@getIndex');

Route::controller('/users', 'UserController');
Route::get('/users', 'UserController@getAll');

Route::get('/c/view/{charity_name}/{page_id}', 'CharityController@getPage');
Route::get('/c/view/{name}', 'CharityController@getCharity');
Route::controller('/c', 'CharityController');
Route::get('/c', 'CharityController@getAll');

Route::controller('pages', 'PageController');

Route::get('/oauth/{provider}', 'OAuthController@getOAuth');
