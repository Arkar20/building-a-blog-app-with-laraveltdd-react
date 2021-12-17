<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavouriteReplyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function auth_user_can_favourite_a_reply()
    {
        $user=User::factory()->create();

        $this->actingAs($user);
        
        $this->withoutExceptionHandling();

         $reply=Comment::factory()->create();

         $response=$this->post('/comments/'.$reply->id.'/favourites');

        $this->assertCount(1,$reply->favourites);

      
    }
    public function test_auth_user_can_favourite_a_reply_once()
    {
        $this->withoutExceptionHandling();
        $user=User::factory()->create();

        $this->actingAs($user);
        

         $reply=Comment::factory()->create();

         $response=$this->post('/comments/'.$reply->id.'/favourites');
         $response=$this->post('/comments/'.$reply->id.'/favourites');

        $this->assertCount(1,$reply->favourites);

      
    }

     
    public function test_guest_cannot_favourite_any_comment()
    {


         $reply=Comment::factory()->create();

         $response=$this->post('/comments/'.$reply->id.'/favourites');

      $response->assertRedirect('/login');

      
    }
}
