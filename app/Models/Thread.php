<?php

namespace App\Models;

use App\Models\User;
use App\Models\Channel;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Thread extends Model
{
    use HasFactory;

    protected $guarded=[""];


    public $withCount=['comments'];

    public function path()
    {
        return '/threads/'. $this->channel->name.'/'.$this->id;
    }

    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }

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
    public function scopeFilter($query,$filters)
    {
        return $filters->apply($query);
    }
}
