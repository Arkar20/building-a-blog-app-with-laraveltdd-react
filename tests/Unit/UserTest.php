<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class User extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_may_have_many_threads()
    {
        
         $thread= Thread::factory()->create();
       

        $this->assertInstanceOf('App\Models\User',$thread->user);


    }
    public function test_user_may_have_many_comments()
    {
    $this->withoutExceptionHandling();        
         $comment= Comment::factory()->create();
       
        $this->assertInstanceOf('App\Models\User',$comment->user);


    }
}
