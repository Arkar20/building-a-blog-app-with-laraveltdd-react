<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadUpdateTest extends TestCase
{

    use RefreshDatabase;
    
    public function test_title_field_is_required_when_updating_thread()
    {
        // $this->withoutExceptionHandling();

        $user=User::factory()->create();

        $this->actingAs($user);

        $thread= Thread::factory()->create(['user_id'=>auth()->id()]);

         $response=$this->patch($thread->path(),['title'=>null,'desc'=>"Changed"]);

        $response->assertSessionHasErrors('title');

    }
    public function test_desc_field_is_required_when_updating_thread()
    {
        // $this->withoutExceptionHandling();

        $user=User::factory()->create();

        $this->actingAs($user);

        $thread= Thread::factory()->create(['user_id'=>auth()->id()]);

         $response=$this->patch($thread->path(),['title'=>"changed",'desc'=>""]);

        $response->assertSessionHasErrors('desc');

    }
    
}
