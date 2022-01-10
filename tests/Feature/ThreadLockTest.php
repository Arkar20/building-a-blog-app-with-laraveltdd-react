<?php

namespace Tests\Feature;

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
}
