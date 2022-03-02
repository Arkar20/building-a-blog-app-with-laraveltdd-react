<?php

namespace App\Filters;

use App\Models\User;
use App\Models\Thread;
use App\Filters\Filter;
use Illuminate\Http\Request;

class ThreadFilter extends Filter{

    protected $filters=['by','popular','uncomment'];

    public function by($username,$query)
    {
         $user=User::where('name',$username)->firstorFail();
            $query=  $query->where('user_id',$user->id);
            return $query;
    }
    public function popular($filter,$query)
    {
          return $query->orderBy('comments_count','desc');

    }         
    public function uncomment($filter,$query)
    {
             return $query->where('comments_count',0);   
           
    }

}