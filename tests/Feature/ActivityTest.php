<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_make_activity_on_creating_threads()
    {
   
         $this->withoutExceptionHandling();

        $thread= Thread::factory()->create();

        
        $this->assertDatabaseCount('activities',$thread->activities->count());
        $this->assertDatabaseHas('activities',[
            'id'=>$thread->activities()->first()->id
        ]);
      
    }
    public function test_user_make_activity_on_replying_threads()
    {
   
         $this->withoutExceptionHandling();

        $thread= Thread::factory()->create();

        $comment= Comment::factory()->create(['thread_id'=>$thread->id]);

        
        
        $this->assertDatabaseHas('activities',[
            'id'=>$comment->activities()->first()->id
        ]);
      
    }
}
