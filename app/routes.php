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

Route::get('contact', 'ContactController@getContact');
Route::post('contact', 'ContactController@postContact');

Route::controller('/c', 'CharityController');
Route::get('/c', 'CharityController@getAll');

Route::controller('pages', 'PageController');
Route::controller('posts', 'PostController');
Route::controller('comments', 'CommentController');

Route::get('help', 'HelpController@getFaq');

Route::get('/oauth/{provider}', 'OAuthController@getOAuth');

Route::group(array('before' => 'auth'), function() {
    Route::get('/favorite/{charity_name}', 'FavoriteController@favoriteCharity');
    Route::get('/unfavorite/{charity_name}', 'FavoriteController@unfavoriteCharity');


    // deleting
    Route::get('delete/charity/{charity_id}', 'DeleteController@deleteCharity');
    Route::get('delete/comment/{comment_id}', 'DeleteController@deleteComment');
    Route::get('delete/page/{page_id}', 'DeleteController@deletePage');

    // editing
    Route::get('edit/charity/{charity_id}', 'EditController@getCharity');
    Route::post('edit/charity/{charity_id}', 'EditController@postCharity');

    Route::get('edit/page/{page_id}', 'EditController@getPage');
    Route::post('edit/page/{page_id}', 'EditController@postPage');

    Route::get('edit/style/{charity_id}', 'EditController@getStyle');
    Route::post('edit/style/{charity_id}', 'EditController@postStyle');


    // create social links
    Route::get('create/social-link/{charity_id}', 'SocialLinkController@getCreate');
    Route::post('create/social-link/{charity_id}', 'SocialLinkController@postCreate');

    // edit charity contributors
    Route::get('contributors/{charity_name}/{page_id?}',
        'ContributorController@getContributors');
    Route::post('contributors/{charity_name}/{page_id?}',
        'ContributorController@getContributors');

    Route::get('create/contributor/{charity_id}/{user_id}',
        'CreateController@createAdmin');


});

// route passwords
Route::get('password/reset', array(
    'uses'   => 'RemindersController@getRemind',
    'as'    => 'password.remind',
));
Route::post('password/reset', array(
    'uses'   => 'RemindersController@postRemind',
    'as'    => 'password.request',
));
Route::get('password/reset/{token}', array(
    'uses'   => 'RemindersController@getReset',
    'as'    => 'password.reset',
));
Route::post('password/reset/{token}', array(
    'uses'   => 'RemindersController@postReset',
    'as'    => 'password.update',
));


Route::post('api/validation/{model}/{field}', 'ApiController@validation');
