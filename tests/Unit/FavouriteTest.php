<?php

namespace Tests\Unit;


use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;


class FavouriteTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_auth_user_unfavourite_function()
    {
        $this->withoutExceptionHandling();
        $user=User::factory()->create();

        $this->actingAs($user);
        

         $comment=Comment::factory()->create();


         //* favourites the comment
         $comment->markFavourite();

         //*unfavourites the comment
         $comment->unmarkFavourite();
         

        $this->assertCount(0,$comment->favourites);

      
    }
    public function test_auth_user_favourite_function()
    {
        $this->withoutExceptionHandling();
        $user=User::factory()->create();

        $this->actingAs($user);
        

         $comment=Comment::factory()->create();


         //* favourites the comment
         $comment->markFavourite();

         //*unfavourites the comment
         $comment->unmarkFavourite();
         

        $this->assertCount(0,$comment->favourites);

      
    }
}
