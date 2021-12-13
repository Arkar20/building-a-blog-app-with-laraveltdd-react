<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
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

   
    public function test_guest_cannot_create_threads()
    {

      $thread=  Thread::factory()->make();

         $response=$this->post('/threads',$thread->toArray());  
         
      $this->assertGuest();
    }
    public function test_auth_user_can_create_thread(){

         $this->withoutExceptionHandling();

         $user=User::factory()->create();

        $this->actingAs($user);

        $thread= Thread::factory()->make(['user_id'=>$user->id]);

        $response=$this->post('/threads',$thread->toArray());

        $this->get('/threads')->assertSee($thread->title);

    }

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
  

}
