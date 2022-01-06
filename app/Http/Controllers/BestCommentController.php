<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class BestCommentController extends Controller
{
   public function store(Comment $comment)
   {
       if(!auth()->user()->isAdmin()){
          abort(403, 'Unauthorized action.');

       }
      return  $comment->markAsBestReply();
   }
}
