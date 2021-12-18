<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileUserTest extends TestCase
{

    use RefreshDatabase;
    
    public function test_profile_page_show_user_information()
    {
        $user=User::factory()->create();

        $this->get('/profile/'.$user->name)->assertSee($user->name);
    }
    public function test_profile_page_show_user_threads()
    {
        $user=User::factory()->create();

        $thread=Thread::factory()->create(['user_id'=>$user->id]);

        $this->get('/profile/'.$user->name)
                ->assertSee($user->name)
                ->assertSee($thread->title)
                ->assertSee($thread->desc);


    }

}
