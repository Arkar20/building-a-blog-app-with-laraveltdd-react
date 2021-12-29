<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
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

    

}
