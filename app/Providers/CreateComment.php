<?php

namespace App\Providers;

use App\Models\Thread;
use App\Jobs\NewComment;
use App\Providers\UserHasComment;
use App\Http\Requests\CommentRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateComment
{
   
    /**
     * Handle the event.
     *
     * @param  \App\Providers\UserHasComment  $event
     * @return void
     */
    public function handle(UserHasComment $event)
    {
      $comment=  $event->thread->comments()->create(['title'=>$event->request->title,'user_id'=>auth()->id()]);  //* also incrementing the comment by model event

         NewComment::dispatch($comment);
        
    }
}
