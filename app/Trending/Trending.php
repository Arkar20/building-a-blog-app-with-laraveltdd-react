<?php
namespace App\Trending;

use Illuminate\Support\Facades\Redis;

class Trending{

    public function getTrending()
    {
        return array_map('json_decode',array_flip(Redis::zrevrange($this->getKey(),0,4,'withscores')));
    }
    public function setTrending($thread)
    {
        if(auth()->check()){
            return Redis::zincrby($this->getKey(),1,json_encode(['title'=>$thread->title,'path'=>$thread->path()]));
        }
        return;
    }
    public function getKey()
    {
        return app()->environment('testing')?'trending_threads_test':'trending_threads';
    }
}