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

     private $user,$thread;
    protected function setUp():void
    {
        parent::setUp();

        $this->user=User::factory()->create();
        $this->actingAs($this->user);
        $this->thread= Thread::factory()->create();

    }
    public function test_user_make_activity_on_creating_threads()
    {
         $this->withoutExceptionHandling();



        $this->assertDatabaseCount('activities',$this->thread->activities->count());
        $this->assertDatabaseHas('activities',[
            'id'=>$this->thread->activities()->first()->id
        ]);
      
    }
    public function test_user_make_activity_on_replying_threads()
    {
           $user=User::factory()->create();

   
         $this->withoutExceptionHandling();


        $comment= Comment::factory()->create(['thread_id'=>$this->thread->id]);

        $this->assertDatabaseHas('activities',[
            'id'=>$comment->activities()->first()->id
        ]);
      
    }

   
  
}
