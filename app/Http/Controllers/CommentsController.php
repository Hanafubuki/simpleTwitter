<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateCommentRequest;
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
    public function store(StoreUpdateCommentRequest $request)
    {
        $comment = new Comment;
        $comment->fill($request->validated());
        $comment->author_id = auth('api')->user()->id;

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
    public function update(StoreUpdateCommentRequest $request, Comment $comment)
    {
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
    public function destroy(Comment $comment)
    {
        if(!$comment){
          return get_error();
        }
        if(!isCorrectUserApi($comment->author_id)){
          return get_error(401);
        }
        $comment->delete();
        return 204;
    }
}
