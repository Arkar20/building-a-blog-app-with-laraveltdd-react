<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;

class BestCommentController extends Controller
{
   public function store(Comment $comment)
   {
       if(!auth()->user()->isAdmin()){
           abort(403);
       }
        $comment->markAsBestReply();

        return;
      // return CommentResource::collection($comment->fresh()->thread()->comments()->orderBy('is_best','desc')->paginate(4)); //!decorator pattern

   }
}
