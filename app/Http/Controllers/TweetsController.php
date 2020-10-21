<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tweet;
use App\Http\Resources\Tweet as TweetResource;

class TweetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
      $tweets = Tweet::get();
      return TweetResource::collection($tweets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOne($id)
    {
      $tweet = Tweet::find($id);
      if(!$tweet){
        return get_error(404);
      }
      return TweetResource::collection($tweet);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $tweet = new Tweet;
      if(!$tweet){
        return get_error(404);
      }
      $tweet->author_id = $request->input('author_id');
      $tweet->text = $request->input('text');

      if($tweet->save()){
        return new TweetResource($tweet);
      }
      return get_error();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tweet = Tweet::findOrFail($id);
        if(!$tweet){
          return get_error(404);
        }
        $tweet->text = $request->input('text');

        if($tweet->save()){
          return new TweetResource($tweet);
        }
        return get_error();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tweet = Tweet::findOrFail($id);
        if(!$tweet){
          return get_error(404);
        }
        $tweet->delete();
    }
}
