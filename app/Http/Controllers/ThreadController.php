<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Thread;
use App\Models\Channel;
use App\Trending\Trending;
use Illuminate\Support\Str;
 use App\Filters\ThreadFilter;
use Illuminate\Http\Request;
use App\Http\Requests\ThreadRequest;
use App\Http\Requests\ThreadUpdateRequest;
use App\Http\Resources\CommentResource;
use Error;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified'])->only('store','destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel=null,ThreadFilter $filters,Trending $trending)
    {
         $threads= $this->getThreads($channel,$filters);
         
         if(request()->wantsJson()){
            return response()->json($threads);
        }

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

        $thread=Thread::create([
                'title'=>$request->get('title'),
                'desc'=>$request->get('desc'),
                'user_id'=>auth()->id(),
                'channel_id'=>$request->channel_id,
                'slug'=>Str::slug($request->title)
            ]);
       
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
            
             $thread->visit()->record();

             $trending->setTrending($thread);

            $comments=$thread->comments()->paginate(20);

            return view('threads.show',compact('thread','comments'));
        }
              $comments= CommentResource::collection($thread->comments()->orderBy('is_best','desc')->paginate(4)); //!decorator pattern
        

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
        $this->authorize('update',$thread);

        return view('threads.edit',compact('thread'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Channel $channel, Thread $thread,ThreadUpdateRequest $request)
    {
       
        $this->authorize('update',$thread);

        $thread->update([
            'title'=>$request->title,
            'desc'=>$request->desc    
        ]);

        return back();
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
   

     

        // return $threads->get();
        $threads=$threads->with('channel')->latest()->paginate(10);

        
        return $threads;
    }
}
