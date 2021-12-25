<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

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
}
