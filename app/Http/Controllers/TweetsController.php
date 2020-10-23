<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Http\Resources\Tweet as TweetResource;
use Illuminate\Support\Facades\Validator;

class TweetsController extends Controller
{
    /**
     * Get all tweets from user id
     *
     * @return \Illuminate\Http\Response
     */
    public function getFromUser($id)
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
    public function store(Request $request)
    {
      //Check if tweet isn't blank
      $validator = $this->validator($request->all());
      if($validator->fails()){
          return response(get_error(400, $validator->errors()->all()),400);
      }

      $tweet = new Tweet;
      $tweet->author_id = auth('api')->user()->id;
      $tweet->text = $request->input('text');

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
    public function update(Request $request, $id)
    {
        //Check if tweet isn't blank
        $validator = $this->validator($request->all());
        if($validator->fails()){
            return response(get_error(400, $validator->errors()->all()),400);
        }

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
     * Remove tweet from storage.
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


    /**
     * Get a validator for an incoming update request.
     * Must insert old\current password.
     * Password must be at least with length 8, with a special character and match the password_confirmation input.
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'text' => ['required'],
        ]);
    }

}
