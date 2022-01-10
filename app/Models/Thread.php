<?php

namespace App\Models;

use App\Models\User;
use App\Visit\Visit;
use App\Models\Channel;
use App\Models\Comment;
use App\Models\Activity;
use Illuminate\Support\Str;
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

    protected $guarded=[];
 
    public $with=['channel'];

    public $withCount=['comments'];

    public $appends=['path','is_subscribed'];

    public $casts=['lock'];

    //!helpers
    public function path()
    {
        return '/threads/'. $this->channel->name.'/'.$this->slug;
    }

    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }
    public function getPathAttribute()
    {
        return $this->path();   
    }
     public function setSlugAttribute($slug)
    {

        if(static::whereSlug($slug=Str::slug($slug))->exists())
        {
           $slug=$this->incrementSlug($slug);
        }

        $this->attributes['slug']= $slug;


    }
    public function incrementSlug($slug)
    {
         $original=$slug;
        $counter=2;

        while(static::where('slug',$slug)->exists()){
            return $original.'-'.$counter++;
        }
        // dd($slug);
        return $slug;
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

    public function getIsSubscribedAttribute()
    {
        return $this->subscriptions()->where('user_id',auth()->id())->exists();
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

    // !record visit 

    public function visit()
    {
        return new Visit($this);
    }

    //!locking the thread
    public function locked()
    {
        if(auth()->user()->isAdmin()){
             $this->update(['lock'=>!$this->lock]);
        }
    }
   
}
