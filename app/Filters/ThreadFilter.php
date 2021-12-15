<?php

namespace App\Filters;

use App\Models\User;
use App\Models\Thread;
use App\Filters\Filter;
use Illuminate\Http\Request;

class ThreadFilter extends Filter{

    protected $filters=['by'];

    public function by($username,$query)
    {
         $user=User::where('name',$username)->firstorFail();
              return  $query->where('user_id',$user->id);
    }

}