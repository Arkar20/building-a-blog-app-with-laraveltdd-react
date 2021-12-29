<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_may_have_many_threads()
    {
        
         $thread= Thread::factory()->create();
       

        $this->assertInstanceOf('App\Models\User',$thread->user);


    }
    public function test_user_may_have_many_comments()
    {
    $this->withoutExceptionHandling();        
         $comment= Comment::factory()->create();
       
        $this->assertInstanceOf('App\Models\User',$comment->user);


    }
    public function test_user_last_reply()
    {
         $user=User::factory()->create();

         $thread=Thread::factory()->create();

         $comment1= Comment::factory()->create(['user_id'=>$user->id,'thread_id'=>$thread->id,'created_at'=>Carbon::now()->subMinute()]);

         $comment2= Comment::factory()->create(['user_id'=>$user->id,'thread_id'=>$thread->id]);

        //  dd($user->lastComment->toArray());
        // dd($comment2);
        //  dd($user->fresh()->lastReply()->toArray());
         $this->assertEquals($user->lastComment->id,$comment2->id);

        
    }
}
