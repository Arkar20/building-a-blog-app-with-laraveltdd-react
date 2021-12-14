<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateCommentTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_auth_user_can_create_comment()
    {
      $this->withoutExceptionHandling();
        $user=User::factory()->create();

        $this->actingAs($user);
        
        $this->withoutExceptionHandling();

        $thread=Thread::factory()->create();

        $comment=Comment::factory()->make(['thread_id'=>$thread->id]);

        $response=$this->post('/comments/'.$thread->id,$comment->toArray());

        $this->get($thread->path())->assertSee($comment->title);


    }
     public function test_title_field_is_required()
    {
        $user=User::factory()->create();

       $this->actingAs($user);

        $thread=Thread::factory()->create();

      $comment= Comment::factory()->make(['title'=>null,'thread_id'=>$thread->id]);

      $response=$this->post('/comments/'.$thread->id,$comment->toArray());

      $response->assertSessionHasErrors('title');
       
    }
     public function test_guest_cannot_create_comments()
    {


      $thread=  Thread::factory()->create();

        $comment=Comment::factory()->make(['thread_id'=>$thread->id]);

        $response=$this->post('/comments/'.$thread->id,$thread->toArray());  
         
      $this->assertGuest();
    }
}
