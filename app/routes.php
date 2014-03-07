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

#Route::get('/c/view/{charity_name}/{page_id}', 'CharityController@getPage');
#Route::get('/c/view/{name}', 'CharityController@getCharity');
Route::controller('/c', 'CharityController');
Route::get('/c', 'CharityController@getAll');

Route::controller('pages', 'PageController');
Route::controller('posts', 'PostController');
Route::controller('comments', 'CommentController');

Route::get('help', 'HelpController@getFaq');

Route::get('/oauth/{provider}', 'OAuthController@getOAuth');

Route::get('/favorite/{charity_name}', 'FavoriteController@favoriteCharity');
Route::get('/unfavorite/{charity_name}', 'FavoriteController@unfavoriteCharity');

Route::group(array('before' => 'auth'), function() {

    // deleting
    Route::get('delete/charity/{charity_id}', 'DeleteController@deleteCharity');
    Route::get('delete/comment/{comment_id}', 'DeleteController@deleteComment');
    Route::get('delete/page/{page_id}', 'DeleteController@deletePage');

    // editing
    Route::get('edit/page/{page_id}', 'EditController@getPage');
    Route::post('edit/page/{page_id}', 'EditController@postPage');

    // 
    #Route::get('create/contributor/page/{page_id}/user/{user_id}',
    #    'CreateController@createContributor');
    Route::get('create/contributor/{charity_id}/{user_id}',
        'CreateController@createAdmin');

    Route::get('contributors/{charity_name}/{page_id?}',
        'ContributorController@getContributors');
    Route::post('contributors/{charity_name}/{page_id?}',
        'ContributorController@getContributors');

});
