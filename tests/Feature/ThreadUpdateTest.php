<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadUpdateTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_only_owner_can_update_thread()
    {

        $user=User::factory()->create();

        $this->actingAs($user);

        $thread= Thread::factory()->create();

        //if the thread user id is not loggined user then abort

         $response=$this->patchJson($thread->path(),['title'=>"Changed",'desc'=>"Changed"]);

         $response->assertStatus(403);

        //if the thread user id is loggined user then proceed

        $thread= Thread::factory()->create(['user_id'=>$user->id]);

         $response=$this->patchJson($thread->path(),['title'=>"Changed",'desc'=>"Changed"]);

        $this->assertEquals($thread->fresh()->title,'Changed');

        
    }
   
}
