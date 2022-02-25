<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateTweetRequest;
use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Http\Resources\Tweet as TweetResource;
use Illuminate\Support\Facades\Validator;
use app\Http\Controllers\Collection;

class TweetsController extends Controller
{
    /**
     * Get all tweets from user id
     *
     * @return \Illuminate\Http\Response
     */
    public function getFromUser(int $id)
    {
      $tweet = Tweet::where('author_id',$id)->orderBy('created_at', 'desc')->paginate(10);
      if(count($tweet) == 0){
        return get_error(404);
      }
      return TweetResource::collection($tweet);
    }

    /**
     * Display all tweets.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
      $tweets = Tweet::orderBy('created_at', 'desc')->paginate(10);
      return TweetResource::collection($tweets);
    }



    /**
     * Store a newly created tweet in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateTweetRequest $request)
    {
      $validated = $request->validated();

      $tweet = new Tweet;
      $tweet->author_id = auth('api')->user()->id;
      $tweet->text = $validated['text'];

      if($tweet->save()){
        return new TweetResource($tweet);
      }
      return get_error();
    }

    /**
     * Update tweet.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateTweetRequest $request, Tweet $tweet)
    {
        //$tweet = Tweet::findOrFail($id);
        if(!$tweet){
          return get_error(404);
        }

        $validated = $request->validated();
        $tweet->text = $validated['text'];

        if($tweet->save()){
          return new TweetResource($tweet);
        }
        return get_error();
    }

    /**
     * Remove tweet from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tweet $tweet)
    {
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
