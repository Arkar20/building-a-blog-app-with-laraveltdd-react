<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Thread;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_create_threads()
    {

      $thread=  Thread::factory()->make();

         $this->post('/threads',$thread->toArray());

        $this->get('/threads')->assertSee($thread->title);
    }
}
