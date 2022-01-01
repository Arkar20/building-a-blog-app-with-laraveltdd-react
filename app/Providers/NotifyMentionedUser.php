<?php

namespace App\Providers;

use App\Models\User;
use App\Providers\UserHasComment;
use App\Http\Requests\CommentRequest;
use App\Notifications\UserHasMentioned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyMentionedUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Providers\UserHasComment  $event
     * @return void
     */
    public function handle(UserHasComment $event)
    {
        
         $usersToNotify=  auth()->user()
                ->identifyUsersToNotify($event->request->title);


        $usersToNotify &&  
                $usersToNotify->each->notify(new UserHasMentioned($event->thread));
    
    }
}
