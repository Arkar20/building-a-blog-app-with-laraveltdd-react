<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use App\Models\Channel;
use App\Models\Comment;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     * 
     * @return void
     */
    public function test_a_user_can_visit_threads()
    {

        $thread=Thread::factory()->create();
      

      $response= $this->get('/threads')->assertSee($thread->title);

    
    }
    public function test_a_user_can_visit_single_thread()
    {
        $this->withoutExceptionHandling();

        $thread=Thread::factory()->create();

       $this->get($thread->path())->assertSee($thread->title);
    }
    public function test_threads_can_be_filtered_by_channel_name()
    {

        $this->withoutExceptionHandling();

        $channel=Channel::factory()->create();



        $threadByChannel=Thread::factory()->create(['channel_id'=>$channel->id]);
        $threadNotByChannel=Thread::factory()->create();

        // dd($threadNotByChannel);

       $this->get('/threads/'.$channel->name)
             ->assertSee($threadByChannel->title)
            ->assertDontSee($threadNotByChannel->title);

      
    }
    public function test_threads_can_be_filtered_by_username()
    {

        $this->withoutExceptionHandling();
         $user=User::factory()->create(['name'=>"tester"]);


         $threadbyuser=  Thread::factory()->create(['user_id'=>$user->id]);

         $threadnotbyuser= Thread::factory()->create();

       $response  =$this->get('/threads?by=tester')
        // dd($response);         
        ->assertSee($threadbyuser->title);

    }

    public function test_threads_can_be_filtered_by_popularity_based_on_comments_count()
    {

        $thread1=Thread::factory()->create();
       $threadWith4comments=Comment::factory(4)->create(['thread_id'=>1]);
        
    //    dd($thread1->with('comments')->get()->toArray());

        $thread2=Thread::factory()->create();
       $threadWith3comments=Comment::factory(3)->create(['thread_id'=>$thread2->id]);


        $thread3=Thread::factory()->create();
       $threadWith2comments=Comment::factory(2)->create(['thread_id'=>$thread3->id]);

       $response=$this->getJson('/threads?popular=1')->json();
       $this->assertEquals([4,3,2],array_column($response,'comments_count'));


    }
}
