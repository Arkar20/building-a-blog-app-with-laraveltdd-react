<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Thread;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     * 
     * @return void
     */
    public function test_a_user_can_visit_threads()
    {

        $thread=Thread::factory()->create();
      

       $response=$this->get('/threads')->assertSee($thread->title);
    }
    public function test_a_user_can_visit_single_thread()
    {

        $thread=Thread::factory()->create();
      

       $response=$this->get('/threads/{thread->id}')->assertSee($thread->title);
    }
}
