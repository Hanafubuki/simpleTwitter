<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/


/*
* Public routes
* Transform any return data into JSON
* CORS implementation
*/
Route::group(['middleware' => ['cors', 'json.response']], function () {
    //Authorization
    Route::post('/v1/auth/register', 'App\Http\Controllers\AuthsController@register');
    Route::post('/v1/auth/login', 'App\Http\Controllers\AuthsController@login');
});


/*
* Protected routes that user needs to be logged in (pass login token)
*/
Route::middleware('auth:api')->group(function () {
    //Authorization
    Route::post('/v1/auth/logout', 'App\Http\Controllers\AuthsController@logout');

    //Tweets
    Route::get('/v1/tweets/{id}', 'App\Http\Controllers\TweetsController@getFromUser');
    Route::get('/v1/tweets', 'App\Http\Controllers\TweetsController@getAll');
    Route::post('/v1/tweets', 'App\Http\Controllers\TweetsController@store');
    Route::put('/v1/tweets/{id}', 'App\Http\Controllers\TweetsController@update');
    Route::delete('/v1/tweets/{id}', 'App\Http\Controllers\TweetsController@destroy');

    //Users
    Route::get('/v1/users/{id}', 'App\Http\Controllers\UsersController@getOne');
    Route::put('/v1/users/{id}', 'App\Http\Controllers\UsersController@update');
    Route::delete('/v1/users/{id}', 'App\Http\Controllers\UsersController@destroy');

    //Comments
    Route::get('/v1/comments', 'App\Http\Controllers\CommentsController@get');
    Route::post('/v1/comments', 'App\Http\Controllers\CommentsController@store');
    Route::put('/v1/comments/{id}', 'App\Http\Controllers\CommentsController@update');
    Route::delete('/v1/comments/{id}', 'App\Http\Controllers\CommentsController@destroy');
});


/*
* Fallback message to api not found
*/
Route::fallback(function(){
    return response()->json(
      [
        'message' => 'Page Not Found.'
      ],
      404);
});
