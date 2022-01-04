<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_may_have_many_threads()
    {
        
         $thread= Thread::factory()->create();
       

        $this->assertInstanceOf('App\Models\User',$thread->user);


    }
    public function test_user_may_have_many_comments()
    {
    $this->withoutExceptionHandling();        
         $comment= Comment::factory()->create();
       
        $this->assertInstanceOf('App\Models\User',$comment->user);


    }
    public function test_user_last_reply()
    {
         $user=User::factory()->create();

         $thread=Thread::factory()->create();

         $comment1= Comment::factory()->create(['user_id'=>$user->id,'thread_id'=>$thread->id,'created_at'=>Carbon::now()->subMinute()]);

         $comment2= Comment::factory()->create(['user_id'=>$user->id,'thread_id'=>$thread->id]);

     
         $this->assertEquals($user->lastComment->id,$comment2->id);

        
    }
    public function test_user_have_to_verify_email_before_creating_thread()
    {
            $user=User::factory()->create(['email_verified_at'=>null]);

            $this->actingAs($user);

             $thread=Thread::factory()->make();



            $response=$this->post('/threads',$thread->toArray())->assertRedirect('/email/verify');  


        
    }
}
