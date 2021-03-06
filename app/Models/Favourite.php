<?php

namespace App\Models;

use App\Traits\ActivityTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favourite extends Model
{
    use HasFactory,ActivityTrait;

    protected $fillable=['user_id','favouriteable_id','favouriteable_type'];

    protected static function boot(){
        parent::boot();
        static::deleting(function($model){
            
            return  $model->activities->each->delete();

        });
    }

     public function activities()
    {
        return $this->morphMany(Activity::class,'activity');
    }
     public function favouriteable()
    {
        return $this->morphTo();
    }
   
}
