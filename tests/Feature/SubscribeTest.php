<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_auth_user_can_subscribe_to_a_thread()
    // {
    //     $this->withoutExceptionHandling();

    //     $user=User::factory()->create();

    //     $this->actingAs($user);

    //     $thread=Thread::factory()->create();

    //     //*hit some url to subscribe
    //     $this->post(`/thread/{$thread->id}/subscribe`);

    //     //*see the subscriptions count of the thread to 1
    //     $this->assertDatabaseCount(1,$thread->subscriptions);


    // }
}