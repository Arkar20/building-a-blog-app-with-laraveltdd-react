<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Thread;
use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
 use App\Filters\ThreadFilter;
use App\Http\Requests\ThreadRequest;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\CommentResource;
use App\Trending\Trending;
use Illuminate\Support\Facades\Redis;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store','destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel=null,ThreadFilter $filters,Trending $trending)
    {
         $threads= $this->getThreads($channel,$filters);

          $trending_threads=$trending->getTrending();
       
       return view('threads.index',compact('threads','trending_threads'));
    }
    
   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( ThreadRequest $request)
    {
        $thread=Thread::create(['title'=>$request->get('title'),'desc'=>$request->get('desc'),'user_id'=>auth()->id(),'channel_id'=>$request->channel_id]);
       
        return redirect('/threads')->with('success','Thread Has Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel,Thread $thread,Trending $trending)
    {

        if(!request()->wantsJson()){

             $thread->recordVisitedTime();
            
            $comments=$thread->comments()->paginate(20);

            $trending->setTrending($thread);
            
            return view('threads.show',compact('thread','comments'));
        }
             $comments= CommentResource::collection($thread->comments()->latest()->paginate(4)); //!decorator pattern

            return $comments;


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
       if(auth()->user()->cannot('update',$thread)){
           abort(403);
       }
             $thread->comments->each->delete();
          $thread->delete();

        return redirect('/threads');
    }
    public function getThreads($channel,ThreadFilter $filters)
    {
         if($channel){
        
            $threads=$channel->threads();

        }else{
            $threads=Thread::query();
        }


        $threads=$threads->filter($filters);
   

        if(request()->wantsJson()){
            return response()->json($threads->get());
        }

        // return $threads->get();
        $threads=$threads->with('channel')->latest()->paginate(10);

        return $threads;
    }
}
