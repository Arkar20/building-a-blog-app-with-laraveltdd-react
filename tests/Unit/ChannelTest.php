<?php

namespace Tests\TestCase;

use Tests\TestCase;
use App\Models\Thread;
use App\Models\Channel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChannelTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_has_many_threads()
    {

        $this->withoutExceptionHandling();

        $channel=Channel::factory()->create();

        $thread1=Thread::factory()->create(['channel_id'=>$channel->id]);
        $thread2=Thread::factory()->create(['channel_id'=>$channel->id]);

        // dd($thread1);

        $this->assertEquals($thread1->channel->id,$channel->id);
        $this->assertEquals($thread2->channel->id,$channel->id);

       
    }
}
