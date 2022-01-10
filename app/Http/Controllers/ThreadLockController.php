<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadLockController extends Controller
{
    public function store(Thread $thread)
    {
     
            $thread->locked();

            return back();
        
    }
}
