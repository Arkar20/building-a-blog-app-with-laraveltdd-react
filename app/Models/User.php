<?php

namespace App\Models;

use App\Models\Thread;
use App\Models\Comment;
use App\Models\Activity;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
  

    protected $appends=['avatarPath'];

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    //*helpers
    public function getVisitedCacheKey($threadid)
    {
        
        return sprintf('user_%s_thread_%s',auth()->id(),$threadid);
        
    }
    public function lastComment()
    {
        return $this->fresh()->hasOne(Comment::class)->latest();
    }
     public function identifyUsersToNotify($title)
    {
        preg_match_all('/@(\w+)/',$title,$names);
   
        return $names[0] ? User::whereIn('name',$names)->get():null;
    }
    public function getAvatarPathAttribute($value)
    {
        return asset($this->avatar ?? 'avatars/default.jpg');
    }
}
