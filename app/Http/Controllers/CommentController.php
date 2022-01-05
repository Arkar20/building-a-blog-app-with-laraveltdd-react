<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Thread;
use App\Models\Channel;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Inspections\Spam;
use App\Providers\DeleteComment;
use Illuminate\Support\Facades\Gate;
use Whoops\Exception\ErrorException;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Notifications\CommentNotification;
use App\Notifications\UserHasMentioned;
use App\Providers\CreateComment;
use App\Providers\UserHasComment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function __construct()
        {
            $this->middleware('auth')->only('store');
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Thread $thread,CommentRequest $request)
    {
            
        // if(Gate::denies('create',new Comment)){
        //         return response("Sorry You Are tryig too much :)",429);
        //     }
       

        event(new UserHasComment($thread,$request));

        if(request()->wantsJson()){
            return $thread;
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Thread $thread)
    {
          $comments= CommentResource::collection($thread->comments()->latest()->paginate(4)); //!decorator pattern


        return $comments;

        

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {

        if(auth()->user()->cannot('delete',$comment)){
         return  abort(403);
        }
        
        $comment->delete();

        if(request()->wantsJson()){
            return response()->json(['success'=>'Delete Successful!']);
        }

      return back();
    }
}
