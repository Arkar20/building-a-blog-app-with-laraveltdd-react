<?php

namespace App\Models;

use App\Models\User;
use App\Models\Channel;
use App\Models\Comment;
use App\Models\Activity;
use App\Traits\ActivityTrait;
use App\Models\ThreadSubscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Thread extends Model
{
    use HasFactory,ActivityTrait;

    protected $guarded=[""];
 
    public $with=['channel'];

    public $withCount=['comments'];

    //!helpers
    public function path()
    {
        return '/threads/'. $this->channel->name.'/'.$this->id;
    }

    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }


    //!lifecycle
    public static function boot(){
        parent::boot();
        static::deleting(function($model){
                   return $model->comments->each->delete();


        });

       
    }

    

    //! relatonships 

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
       public function activities()
    {
        return $this->morphMany(Activity::class,'activity');
    }
    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }



    //! scope
    public function scopeFilter($query,$filters)
    {
        return $filters->apply($query);
    }

    //! functions
    public function subscribe()
    {
        return $this->subscriptions()->create([
            'user_id'=>auth()->id(),
            'thread_id'=>$this->id
        ]);
    }
}
