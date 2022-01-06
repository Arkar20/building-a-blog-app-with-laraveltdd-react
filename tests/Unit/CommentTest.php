<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
  
    public function test_comment_is_a_belongs_to_a_thread()
    {
        $this->withoutExceptionHandling();
        $thread=Thread::factory()->create();
        $comment=Comment::factory()->create(['thread_id'=>$thread->id]);

        $this->assertInstanceOf('App\Models\Thread',$comment->thread);
       
    }
    public function test_comment_has_just_published()
    {
         $thread=Thread::factory()->create();
        $comment=Comment::factory()->create(['thread_id'=>$thread->id]);

        $this->assertTrue($comment->wasJustPublished());

        $comment=Comment::factory()->create(['thread_id'=>$thread->id,'created_at'=>Carbon::now()->subHour()]);
        $this->assertFalse($comment->wasJustPublished());
    }
     public function test_normal_user_cannot_mark_the_reply_as_best_reply()
    {
         $user=User::factory()->create();

        $this->actingAs($user);

        $thread=Thread::factory()->create();

        $comment=Comment::
                  factory()
                  ->create(['thread_id'=>$thread->id]);

        $comment->markAsBestReply();
        
        // $this->assertStatus(403);

        $this->assertEquals(null,$comment->thread->best_comment);
    }
    public function test_only_admin_can_mark_the_reply_as_best_reply()
    {

        $this->withoutExceptionHandling();
         $user=User::factory()->create(['email'=>"admin@admin.com"]);

        $this->actingAs($user);

        $thread=Thread::factory()->create();

        $comment=Comment::
                  factory()
                  ->create(['thread_id'=>$thread->id]);

        $comment->markAsBestReply();

        $this->assertEquals($comment->id,$comment->fresh()->thread->best_comment);
    }
    public function test_comment_model_has_is_best_attribute()
    {
        //thread should hav
         $user=User::factory()->create(['email'=>"admin@admin.com"]);

        $this->actingAs($user);

        $thread=Thread::factory()->create();

        $comment=Comment::
                  factory()
                  ->create(['thread_id'=>$thread->id]);

     
        $comment->markAsBestReply();

        $this->assertTrue($comment->fresh()->is_best);
    }

    

}
