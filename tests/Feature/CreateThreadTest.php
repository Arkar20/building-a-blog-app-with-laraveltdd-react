<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Thread;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadTest extends TestCase
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
     public function test_title_field_is_required()
    {

      $thread= Thread::factory()->make(['title'=>null]);

      $response=$this->post('/threads',$thread->toArray());

      $response->assertSessionHasErrors('title');
       
    }
     public function test_desc_field_is_required()
    {

      $thread= Thread::factory()->make(['desc'=>null]);

      $response=$this->post('/threads',$thread->toArray());

      $response->assertSessionHasErrors('desc');
       
    }
  

}
