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


Route::get('/v1/tweets', 'App\Http\Controllers\TweetsController@getAll');

Route::get('/v1/tweets/{id}', 'App\Http\Controllers\TweetsController@getOne');

Route::post('/v1/tweets', 'App\Http\Controllers\TweetsController@store');

Route::put('/v1/tweets/{id}', 'App\Http\Controllers\TweetsController@update');

Route::delete('/v1/tweets/{id}', 'App\Http\Controllers\TweetsController@destroy');


Route::fallback(function(){
    return response()->json(
      [
        'message' => 'Page Not Found.'
      ],
      404);
});
