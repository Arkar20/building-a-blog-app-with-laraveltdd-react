<?php
namespace App\Traits;

use Illuminate\Support\Facades\Redis;

trait RecordVisitTrait{
     // redis visist cache
    public function getvisistsAttribute()
    {
        return Redis::get($this->cacheKey()) ?:0 ;
    }
    public function recordVisit()
    {
        return Redis::incr($this->cacheKey());
    }
    public function cacheKey()
    {
     return 'threads.'.$this->id.'.visists';   
    }
    public function removeVisist()
    {
        return Redis::del($this->cacheKey());
    }
}