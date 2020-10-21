<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Tweets routes
Route::get('/v1/tweets', 'App\Http\Controllers\TweetsController@getAll');

Route::get('/v1/tweets/{id}', 'App\Http\Controllers\TweetsController@getOne');

Route::post('/v1/tweets', 'App\Http\Controllers\TweetsController@store');

Route::put('/v1/tweets/{id}', 'App\Http\Controllers\TweetsController@update');

Route::delete('/v1/tweets/{id}', 'App\Http\Controllers\TweetsController@destroy');


//User routes
Route::post('/v1/users/register', 'App\Http\Controllers\UsersController@register');

Route::post('/v1/users/login', 'App\Http\Controllers\UsersController@login');

Route::get('/v1/users', 'App\Http\Controllers\UsersController@getAll');

Route::get('/v1/users/{id}', 'App\Http\Controllers\UsersController@getOne');

Route::post('/v1/users', 'App\Http\Controllers\UsersController@store');

Route::put('/v1/users/{id}', 'App\Http\Controllers\UsersController@update');

Route::delete('/v1/users/{id}', 'App\Http\Controllers\UsersController@destroy');



Route::fallback(function(){
    return response()->json(
      [
        'message' => 'Page Not Found.'
      ],
      404);
});
