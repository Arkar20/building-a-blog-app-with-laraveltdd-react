<?php

namespace App\Models;

use App\Models\User;
use App\Models\Thread;
use App\Models\Favourite;
use App\Traits\ActivityTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory,ActivityTrait;

    public $with=['user','thread'];

    public $withCount=['favourites'];

    public $appends=['is_favourited'];

    protected static function boot(){
        parent::boot();
        // static::deleting(function($model){
            
        //     return  $model->favourites->each->delete();

        // });
         static::created(function($model){
        
            return $model->thread->increment('comments_count');
        });
        static::deleted(function($model){
        
            return $model->thread->decrement('comments_count');
        });
    }

    protected $fillable=['title','thread_id','user_id'];

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
    public function markFavourite()
    {
        
      return $this->favourites()->create([
            'user_id'=>auth()->id(),
            'favourited_type'=> get_class($this)
        ]);
    }
    public function getisFavouritedAttribute()
    {
        return $this->favourites()->where('user_id',auth()->id())->exists();
    }
}
