<?php

namespace App\Providers;

use App\Models\Thread;
use Illuminate\Broadcasting\Channel;
use App\Http\Requests\CommentRequest;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserHasComment
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $thread,$request;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Thread $thread, CommentRequest $request)
    {
        $this->thread=$thread;
        $this->request=$request;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    
}
