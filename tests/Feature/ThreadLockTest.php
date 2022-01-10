<?php

namespace Tests\Feature;

use App\Models\Comment;
use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadLockTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_only_admin_user_can_lock_the_thread()
    {
        $this->withoutExceptionHandling();
         $user=User::factory()->create(['email'=>"admin@admin.com"]);
    
        $this->actingAs($user);
        $thread=Thread::factory()->create();    

     //    hit url to lock
        $this->post('/thread/'.$thread->id.'/locked');

        //   thread is locked in db
        $this->assertTrue((Boolean) $thread->fresh()->lock);
    }
    public function test_user_cannot_comment_when_the_thread_is_locked()
    { 
        // $this->withoutExceptionHandling();s

         $user=User::factory()->create(['email'=>"admin@admin.com"]);
    
        $this->actingAs($user);
        $thread=Thread::factory()->create(['lock'=>true]);  

        
         //    hit url to lock
        // $this->post('/thread/'.$thread->id.'/locked');

        $comment=Comment::factory()->make(['thread_id'=>$thread->id]);


        $response=$this->post('/comments/'.$thread->id,$comment->toArray());

        $response->assertStatus(403);

        $this->assertDatabaseCount('comments',0);



        
    }
}
