<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Clockwork\Request\Request;
use App\Providers\UserHasComment;
use App\Http\Requests\CommentRequest;
use Illuminate\Queue\SerializesModels;
use App\Notifications\UserHasMentioned;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\CommentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class NewComment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $comment;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment=$comment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subscripedusersId=$this->comment->thread->subscriptions->pluck('user_id');
        
        $subscripedusersId && $usersToNotify=User::whereIn('id',$subscripedusersId)->chunk(10,function($users) {
            
            return $users->each->notify(new CommentNotification( $this->comment));
        });
    }
}
