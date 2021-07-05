<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Http\Resources\Comment as CommentResource;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
          $comments = Comment::where('author_id', auth('api')->user()->id)->paginate(10);
          return CommentResource::collection($comments);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment = new Comment;
        $comment->text = $request->text;
        $comment->author_id = auth('api')->user()->id;
        $comment->tweet_id = $request->tweet_id;

        if($comment->save()){
          return new CommentResource($comment);
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
        //Check if tweet isn't blank
        $validator = $this->validator($request->all());
        if($validator->fails()){
            return response(get_error(400, $validator->errors()->all()),400);
        }
        $comment = Comment::find($id);
        $comment->text = $request->text;
        if($comment->save()){
          return new CommentResource($comment);
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
        $comment = Comment::findOrFail($id);
        if(!$comment){
          return get_error();
        }
        if(!isCorrectUserApi($comment->author_id)){
          return get_error(401);
        }
        $comment->delete();
        return 204;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'text' => ['required'],
        ]);
    }
}
