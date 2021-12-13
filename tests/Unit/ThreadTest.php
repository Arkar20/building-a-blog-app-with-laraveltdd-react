<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Thread;
use App\Models\Comment;
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
}
