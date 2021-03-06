<?php

namespace Tests\TestCase;

use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribionThreadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_thread_subscribe_fun()
    {
       $this->withoutExceptionHandling();

        $user=User::factory()->create();

        $this->actingAs($user);

        $thread=Thread::factory()->create();

        $thread->subscribe(); //! target fun to test

        $this->assertEquals(1,$thread->subscriptions()->count());


    }
    public function test_thread_unsubscribe_fun()
    {
       $this->withoutExceptionHandling();

        $user=User::factory()->create();

        $this->actingAs($user);

        $thread=Thread::factory()->create();

        $thread->subscribe(); //! subscrube first 

        $thread->unsubscribe(); //* target fun to test

        $this->assertEquals(0,$thread->subscriptions()->count());


    }
  
}
