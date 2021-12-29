<?php

namespace Tests\Feature;

use ErrorException;
use Tests\TestCase;
use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpamTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
  public function test_comment_is_not_stored_in_db_if_it_is_contained_spam()
    {

       $this->withoutExceptionHandling();
       $this->expectException(ErrorException::class);

      $this->actingAs($this->user);
      $thread=Thread::factory()->create();
       $comment=Comment::
                factory()
                ->make(['thread_id'=>$thread->id,'user_id'=>$this->user->id,'title'=>"Customer Service"]);

      $response=$this->post('/comments/'.$thread->id,$comment->toArray());

      $this->assertEquals(0,$thread->fresh()->comments_count);
    }
    public function test_comment_throw_error_exception_if_it_is_contained_spam()
    {

      $this->withoutExceptionHandling();
       $this->expectException(ErrorException::class);

      $this->actingAs($this->user);
      
      $thread=Thread::factory()->create();

       $comment=Comment::
                factory()
                ->make(['thread_id'=>$thread->id,'user_id'=>$this->user->id,'title'=>"Customer Service"]);
      

      $response=$this->post('/comments/'.$thread->id,$comment->toArray());


      $this->assertEquals(0,$thread->fresh()->comments_count);
    }
}
