<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadSubscriptionController extends Controller
{
    public function store(Thread $thread)
    {
        if(!$thread->subscriptions()->where('user_id',auth()->id())->exists())
            $thread->subscribe();

        return back();
    }
}
