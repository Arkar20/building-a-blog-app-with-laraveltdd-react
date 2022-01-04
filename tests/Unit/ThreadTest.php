<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }
    public function test_threads_has_many_comments()
    {
        // $this->withoutExceptionHandling();

        $thread=Thread::factory()->create();

        $comment=Comment::factory()->create(['thread_id'=>$thread->id]);
    
        // dd($thread);
           
        $this->assertInstanceOf(Comment::class,$thread->comments[0]);

    }
    public function test_thread_has_slug()
    {
        $this->withoutExceptionHandling();

        $thread=Thread::factory()->create();
        
        
        $this->assertEquals($thread->slug,Str::slug($thread->title));
        
    }

   
}
