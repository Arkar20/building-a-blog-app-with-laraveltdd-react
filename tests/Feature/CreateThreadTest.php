<?php

namespace Tests\Feature;

use App\Models\Channel;
use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use App\Models\Comment;
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

    public function test_only_auth_owner_can_delete_thread()
    {

      $user=User::factory()->create();

      $this->actingAs($user);


      $threadToDeleteByLoginUser=Thread::factory()->create(['user_id' => $user->id]);

      $commentsToDelete=Comment::factory()->create(['thread_id'=>$threadToDeleteByLoginUser->id]);
      
      $threadNotByLoginUser=Thread::factory()->create();

      $this->delete('/threads/'.$threadToDeleteByLoginUser->id);

      $this->delete('/threads/'.$threadNotByLoginUser->id);

        $this->assertDatabaseMissing('threads',$threadToDeleteByLoginUser->toArray());
        $this->assertDatabaseMissing('comments',$threadToDeleteByLoginUser->comments->toArray());

      $this->assertEquals(0,$threadToDeleteByLoginUser->activities->count());

        $this->get('/threads')->assertSee($threadNotByLoginUser->title);

    }
    public function test_thread_require_unique_slug()
    {

      $user=User::factory()->create();
      $this->actingAs($user);
     $this->withoutExceptionHandling();
      $thread=Thread::factory()->create(['title'=>"foo bar",'slug'=>"foo-bar"]);

      $this->assertTrue(Thread::where('slug',$thread->slug)->exists());
      
      $res=$this->post('/threads',$thread->toArray());

    $threads=Thread::all()->toArray()[1];

      $this->assertEquals('foo-bar-2',$threads['slug']);

      
    }


    public function test_guest_cannnot_delete_thread()
    {


      $threadToDeleteByLoginUser=Thread::factory()->create();

      
       $this->delete('/threads/'.$threadToDeleteByLoginUser->id)->assertRedirect('/login');

    }

   

     

}
