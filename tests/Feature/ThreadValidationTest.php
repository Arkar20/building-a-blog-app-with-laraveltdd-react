<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use App\Models\Channel;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadValidationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_thread_title_field_is_required()
    {

      $user=User::factory()->create();

     $this->actingAs($user);

      $thread= Thread::factory()->make(['title'=>null]);

      $response=$this->post('/threads',$thread->toArray());

      $response->assertSessionHasErrors('title');
       
    }
     public function test_thread_desc_field_is_required()
    {

       $user=User::factory()->create();

       $this->actingAs($user);


      $thread= Thread::factory()->make(['desc'=>null]);

      $response=$this->post('/threads',$thread->toArray());

      $response->assertSessionHasErrors('desc');
       
    }
     public function test_thread_channel_id_field_is_required()
    {

       $user=User::factory()->create();

       $this->actingAs($user);

      $thread= Thread::factory()->make(['channel_id'=>null]);

      $response=$this->post('/threads',$thread->toArray());

      $response->assertSessionHasErrors('channel_id');
       
    }
     public function test_thread_channel_id_field_has_to_be_exists_to_register_in_Thread()
    {

       $user=User::factory()->create();

       $this->actingAs($user);

      $thread= Thread::factory()->make(['channel_id'=>2]);

      $response=$this->post('/threads',$thread->toArray());

      $response->assertSessionHasErrors('channel_id');
       
    }
    
  
}
