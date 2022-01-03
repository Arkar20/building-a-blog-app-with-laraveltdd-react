<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AvatarTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_only_guest_members_can_upload_imgs()
    {
        $user=User::factory()->create();
        
        //hit some endpoint and 
        $this->post('/profile/'.$user->name.'/avatar');
        //see the data in the column
        $this->assertGuest();

    }
    public function test_only_auth_members_cannot_upload_invalid_format()
    {
        $user=User::factory()->create();
        $this->actingAs($user);

        //hit some endpoint and 
        $this->json('POST','/profile/'.$user->name.'/avatar',['avatar'=>'not-valid-format'])
            ->assertStatus(422);

    }
    public function test_diplay_default_img_if_the_avatar_is_null()
    {
         $user=User::factory()->create();
        $this->actingAs($user);



        $this->assertEquals('avatars/default.jpg',$user->getAvatar());
        //hit some endpoint and 
        $this->json('POST','/profile/'.$user->name.'/avatar',['avatar'=> $file=UploadedFile::fake()->image('avatar.jpg')]);


        $this->assertEquals('avatars/'.$file->hashName(),$user->getAvatar());

        
    }
    public function test_only_auth_members_can_upload_invalid_format()
    {
        $this->withoutExceptionHandling();
        $user=User::factory()->create();

        $this->actingAs($user);


        $fileInStorage=Storage::fake('public');

        //hit some endpoint and 
        $this->json('POST','/profile/'.$user->name.'/avatar',['avatar'=> $file=UploadedFile::fake()->image('avatar.jpg')]);

        $this->assertEquals($user->avatar,'avatars/'.$file->hashName());
            
       Storage::disk('public')->assertExists('avatars/'.$file->hashName());
    }
}
