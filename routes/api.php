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
    Route::post('/v1/auth/register', 'AuthsController@register');
    Route::post('/v1/auth/login', 'AuthsController@login');
});


/*
* Protected routes that user needs to be logged in (pass login token)
*/
Route::middleware('auth:api')->prefix('v1')->namespace('App\Http\Controllers')->group(function () {
    //Authorization
    Route::post('/auth/logout', 'AuthsController@logout');

    Route::apiResources([
        'tweets' => TweetsController::class,
        'users' => UsersController::class,
        'comments' => CommentsController::class,
    ]);
    Route::get('tweets/{id}', 'TweetsController@getFromUser');
    Route::get('/comments', 'CommentsController@get');
});


/*
* Fallback message to api not found
*/
Route::fallback(function(){
    return response()->json(
      [
        'message' => 'API Not Found.'
      ],
      404);
});
