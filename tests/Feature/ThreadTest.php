<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Thread;
use App\Models\Channel;
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
      

       $this->get('/threads')->assertSee($thread->title);
    }
    public function test_a_user_can_visit_single_thread()
    {
        $this->withoutExceptionHandling();

        $thread=Thread::factory()->create();

       $this->get($thread->path())->assertSee($thread->title);
    }
    public function test_threads_can_be_filtered_by_channel_name()
    {

        $this->withoutExceptionHandling();
        $channel=Channel::factory()->create();

        $thread=Thread::factory()->create(['channel_id'=>$channel->id]);

       $this->get('/threads/'.$channel->name)->assertSee($thread->title);
    }
}
