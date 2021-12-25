<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
   public function store(Comment $comment)
   {

    if(!$comment->favourites()->where('user_id',auth()->id())->exists()){

        $comment->unmarkFavourite();
    }
    else{
        $comment->markFavourite();

    }

        return back();
   }
}
