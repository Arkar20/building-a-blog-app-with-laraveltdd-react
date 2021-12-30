<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MetionUserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_mentioned_user_got_notify_by_the_user()
    {
        $this->withoutExceptionHandling();

        $user=User::factory()->create();
         $this->actingAs($user);
        
        $userToBeMentioned=User::factory()->create(['name'=>"JohnDoe"]);
        
        $thread=Thread::factory()->create();

        $comment=Comment::factory()->make(['thread_id'=>$thread->id,'title'=>'@JohnDoe is something']);
        //hit the comment url to with the mentioned name

        $response=$this->post('/comments/'.$thread->id,$comment->toArray());
        // notify all the mentioned users

        $this->assertEquals(1, $userToBeMentioned->notifications->count());
        



    }
}
