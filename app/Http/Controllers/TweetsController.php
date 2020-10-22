<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Http\Resources\Tweet as TweetResource;

class TweetsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFromUser($id)
    {
      $tweet = Tweet::where('author_id',$id)->get();
      if(count($tweet) == 0){
        return get_error(404);
      }
      return TweetResource::collection($tweet);
    }

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $tweet = new Tweet;
      $tweet->author_id = auth('api')->user()->id;
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
        if(!isCorrectUserApi($tweet->author_id)){
          return get_error(401);
        }
        $tweet->delete();
        return 204;
    }

}
