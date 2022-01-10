<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use phpDocumentor\Reflection\Types\Boolean;

class ThreadLockTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_thread_can_be_locked()
    {
       $user=User::factory()->create(['email'=>"admin@admin.com"]);
    
       $this->actingAs($user);

         $thread=Thread::factory()->create();    

        $thread->locked();

        $this->assertTrue((Boolean) $thread->lock);
    }
    public function test_normal_user_cannot_locked()
    {
        $this->withoutExceptionHandling();
      $user=User::factory()->create();
    
      $thread=Thread::factory()->create();    

         $this->actingAs($user);

        $thread->locked();

      $this->assertFalse((Boolean) $thread->fresh()->lock);
      
    }
    public function test_only_admin_can_locked()
    {
      $user=User::factory()->create(['email'=>"admin@admin.com"]);
    
      $this->actingAs($user);
      $thread=Thread::factory()->create();    


         $thread->locked();
     

      $this->assertTrue((Boolean) $thread->fresh()->lock);
      
    }
}
