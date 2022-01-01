<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentionedUserTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_comment_can_identify_users_to_mentions()
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

        $this->assertEquals($userToBeMentioned->id,auth()->user()->identifyUsersToNotify($comment->title)->first()->id);
        
    }
    public function test_tranform_mentioned_user_into_anchor_tag()
    {
        $comment=Comment::factory()->make(['title'=>"Hello @John-Doe"]);

        $this->assertEquals('Hello <a href="/profile/John-Doe">@John-Doe</a>',$comment->title);

    }
}
