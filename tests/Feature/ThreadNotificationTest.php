<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadNotificationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_auth_user_can_have_notificaiton_after_subscribed_to_the_thread()
    {
         $this->withoutExceptionHandling();

        $user1=User::factory()->create();
        $user2=User::factory()->create();


        $thread=Thread::factory()->create();

        $thread->subscribe($user1->id);//!first user subscribing
        $thread->subscribe($user2->id);//!second user subscribing to the thread
        

       //* add some reply to the subscribed thread
       $comment=Comment::factory()->create(['thread_id'=>$thread->id]);

        //* both user 1 and user2 have the notifications
        $this->assertEquals(1,$user1->notifications->count());


       
    }
    public function test_user_can_mark_a_single_notification_as_read()
    {
         $this->withoutExceptionHandling();

        $user=User::factory()->create();

        $this->actingAs($user);

        $thread=Thread::factory()->create();

        $thread->subscribe();//!first user subscribing

          //* add some reply to the subscribed thread
       $comment=Comment::factory()->create(['thread_id'=>$thread->id]);
            // /notifications/notification:id/markasread
       //* hit url to mark as read
       $this->delete('/notifications/'.auth()->user()->unreadNotifications()->first()->id.'/markasread');

       // *see 0 count in notification of the user
      $this->assertEquals(0,$user->notifications->count());
    }
}
