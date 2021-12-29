<?php

namespace Tests\Feature;

use ErrorException;
use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
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
    private $user,$thread;

      public function setUp():void
      {
        parent::setUp();

          $this->user=User::factory()->create();
          
          $this->thread=Thread::factory()->create(['user_id'=>$this->user->id]);

      }
   
    public function test_auth_user_can_create_comment()
    {
      $this->withoutExceptionHandling();
       

        $this->actingAs($this->user);
        
        $this->withoutExceptionHandling();

        $thread=Thread::factory()->create();

        $comment=Comment::factory()->make(['thread_id'=>$thread->id]);

        $response=$this->post('/comments/'.$thread->id,$comment->toArray());

        $this->get($thread->path());
        
        $this->assertDatabaseHas('comments',['title'=>$comment->title]);


    }
     public function test_title_field_is_required()
    {
      $this->actingAs($this->user);
      
      $thread=Thread::factory()->create();

      $comment= Comment::factory()->make(['title'=>null,'thread_id'=>$thread->id]);

      $response=$this->post('/comments/'.$thread->id,$comment->toArray());

      $response->assertSessionHasErrors('title');
       
    }
     public function test_guest_cannot_create_comments()
    {
       $comment=Comment::factory()->make(['thread_id'=>$this->thread->id]);

        $response=$this->post('/comments/'.$this->thread->id,$this->thread->toArray());  
         
       $this->assertGuest();
    }
    public function test_comment_owner_cannot_delete_commnet()
    {
      $this->actingAs($this->user);

      $anotheruser=User::factory()->create();

      $comment=Comment::
                factory()
                ->create(['thread_id'=>$this->thread->id,'user_id'=>$anotheruser->id]);

      $response=$this->delete('/comments/'.$this->thread->id.'/delete');
      
      $response->assertForbidden();

    }
    public function test_comment_owner_can_delete_commnet()
    {
      $this->actingAs($this->user);


      $comment=Comment::
                factory()
                ->create(['thread_id'=>$this->thread->id,'user_id'=>$this->user->id]);

      $response=$this->delete('/comments/'.$this->thread->id.'/delete');
      
      $this->assertDatabaseCount('comments',0);
    }
    public function test_comment_has_to_be_increased_in_threads_every_time_created()
    {

      $this->withoutExceptionHandling();

      $this->actingAs($this->user);
      $thread=Thread::factory()->create();
       $comment=Comment::
                factory()
                ->make(['thread_id'=>$thread->id,'user_id'=>$this->user->id]);

      $response=$this->post('/comments/'.$thread->id,$comment->toArray());

      $this->assertEquals(1,$thread->fresh()->comments_count);
    }
    public function test_comment_has_to_be_decreased_in_threads_every_time_created()
    {

      $this->withoutExceptionHandling();

      $this->actingAs($this->user);
      $thread=Thread::factory()->create();
       $comment=Comment::
                factory()
                ->make(['thread_id'=>$thread->id,'user_id'=>$this->user->id]);

      $response=$this->post('/comments/'.$thread->id,$comment->toArray());

      $this->assertEquals(1,$thread->fresh()->comments_count);
    }
     public function test_user_can_only_reply_once_per_minute()
    {


      $user=User::factory()->create();

      $this->actingAs($user);
      $thread=Thread::factory()->create();

       $comment1=Comment::
                factory()
                ->make(['thread_id'=>$thread->id,'user_id'=>$user->id]);
       $comment2=Comment::
                factory()
                ->make(['thread_id'=>$thread->id,'user_id'=>$user->id]);

      $response1=$this->post('/comments/'.$thread->id,$comment1->toArray());

   
      $response2=$this->post('/comments/'.$thread->id,$comment2->toArray())->assertStatus(429);

      $this->assertEquals(1,$thread->fresh()->comments_count);

    }
   
}
