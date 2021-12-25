<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
   public function store(Comment $comment)
   {

    if(!$comment->favourites()->where('user_id',auth()->id())->exists()){

        $comment->markFavourite();

        $message="Favourite Successful";
    }
    else{
        $comment->unmarkFavourite();

        $message="unFavourited Successful";
    }


        if(request()->wantsJson()){
            return response()->json(['message',$message]);
        }
        return back();
        
   }
}
