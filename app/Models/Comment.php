<?php

namespace App\Models;

use App\Models\User;
use App\Models\Thread;
use App\Models\Favourite;
use App\Traits\ActivityTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\CommentNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory,ActivityTrait;

    public $with=['user','thread'];

    public $withCount=['favourites'];

    public $appends=['is_favourited'];

    public $casts=['is_best'];

    protected $fillable=['title','thread_id','user_id','is_best'];


     protected static function boot(){
        parent::boot();
        
         static::created(function($model){

                    $subscripedusersId=$model->thread->subscriptions->pluck('user_id');
                   
                 $subscripedusersId && $usersToNotify=User::whereIn('id',$subscripedusersId)->chunk(10,function($users) use($model){
                    
                        return $users->each->notify(new CommentNotification( $model));
                    });
                     $model->thread->increment('comments_count');


        });
         static::deleting(function($model){
            Log::info("Decrementing the comment count in thread");
            return $model->thread->decrement('comments_count');
        });
        static::deleted(function($model){
            Log::info("Comment is deleted and reduce the comment count in thread");
            
                    $model->favourites->each->delete();
                 $model->thread && $model->thread->decrement('comments_count');
        });
    }

    //*relationships
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function favourites()
    {
        return $this->morphMany(Favourite::class,'favouriteable');
    }
         public function activities()
    {
        return $this->morphMany(Activity::class,'activity');
    }
    

    //*mutators
    public function setTitleAttribute($value)
    {
        $this->attributes['title']=preg_replace('/@([\w\-]+)/','<a href="/profile/$1">$0</a>',$value);
    }


    //*fun
    public function markFavourite()
    {
        
      return $this->favourites()->create([
            'user_id'=>auth()->id(),
            'favourited_type'=> get_class($this)
        ]);
    }
    public function unmarkFavourite()
    {
      return $this->favourites()->where('user_id',auth()->id())->delete();
    }
    public function getisFavouritedAttribute()
    {
        return $this->favourites()->where('user_id',auth()->id())->exists();
    }
    public function  wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }
    public function markAsBestReply()
    {

        $this->thread()->update(['best_comment'=>$this->id]);
        $this->thread->comments()->update(['is_best'=>false]);


        $this->update(['is_best'=>true]);
        
        // static::where('id',$this->id)->update(['is_best',false]);
        // static::where('id',$this->id)->update(['is_best',true]);
    }
   
}
