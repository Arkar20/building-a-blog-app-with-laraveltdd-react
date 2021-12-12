<?php

namespace App\Models;

use App\Models\Thread;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable=['title','thread_id'];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}
