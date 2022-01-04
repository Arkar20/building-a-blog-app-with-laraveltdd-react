<?php

namespace App\Visit;

use Illuminate\Support\Facades\Redis;

class Visit {

    private $model;

    public function __construct($model)
    {
        $this->model=$model;
    }
     public function count()
    {
        return Redis::get($this->cacheKey()) ?:0 ;
    }
    public function record()
    {
        return Redis::incr($this->cacheKey());
    }
    public function cacheKey()
    {
     return 'threads.'.$this->model->id.'.visists';   
    }
    public function reset()
    {
        return Redis::del($this->cacheKey());
    }
}