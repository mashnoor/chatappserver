<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('makefriend/{id}/{id_2}', 'UserController@make_friend');

Route::post('addpost/{number}', 'UserController@add_post');

Route::post('addfriends/{number}', 'UserController@addFriends');

Route::post('adduser', 'UserController@adduser');

Route::get('latestposts/{number}', 'UserController@getLatestPosts');

Route::get('getfile/{filename}', 'UserController@getfile');

Route::post('addimage/{number}', 'UserController@add_userimage');

Route::get('getimage/{filename}', 'UserController@getimage');

Route::get('getfriends/{number}', 'UserController@getFriends');

Route::get('getallposts/{number}', 'UserController@getallposts');

Route::post('postcomment', 'CommentController@postcomment');

Route::get('post/{post_id}/islikedby/{user_id}', 'LikeController@isLikedBy');

Route::get('post/{user_id}/like/{post_id}', 'LikeController@like');

Route::get('gettimeline/{user_phone}', 'TimelineController@getTimeline');

Route::get('login/{user_phone}', 'UserController@login');


