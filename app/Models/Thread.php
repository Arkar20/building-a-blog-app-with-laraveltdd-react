<?php

namespace App\Models;

use App\Models\User;
use App\Models\Channel;
use App\Models\Comment;
use App\Models\Activity;
use App\Traits\ActivityTrait;
use Illuminate\Support\Carbon;
use App\Models\ThreadSubscription;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Thread extends Model
{
    use HasFactory,ActivityTrait;

    protected $guarded=[""];
 
    public $with=['channel'];

    public $withCount=['comments'];

    public $appends=['path'];

    //!helpers
    public function path()
    {
        return '/threads/'. $this->channel->name.'/'.$this->id;
    }

    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }
    public function getPathAttribute()
    {
        return $this->path();   
    }


    //!lifecycle
    protected static function boot(){
        parent::boot();

        static::created(function($model){

            Log::info("Therad is creating");
        });
        static::deleted(function($model){
            
            Log::info("Therad is deleted and commeting will be deleted");

               $model->comments->each->delete();
            
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
    public function subscribe($userId=0)
    {

        $id=$userId?:auth()->id();

        return $this->subscriptions()->create([
            'user_id'=>$id,
            'thread_id'=>$this->id
        ]);
    }
    public function unsubscribe()
    {
        return $this->subscriptions()->where('user_id',auth()->id())->delete();
    }

    public function hasNewUpdates()
    {
        if (!auth()->check()) return false;
        $key=auth()->user()->getVisitedCacheKey($this->id);
        $lastVisitedTime=Cache::get($key);

        return $this->updated_at > $lastVisitedTime;
    }
    public function recordVisitedTime()
    {
        if (!auth()->check()) return ;

        $key=auth()->user()->getVisitedCacheKey($threadid=$this->id);
        
        Cache::forever($key,Carbon::now());
    }
}
