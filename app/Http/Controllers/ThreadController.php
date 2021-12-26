<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Thread;
use App\Models\Channel;
use Illuminate\Http\Request;
use App\Http\Requests\ThreadRequest;
 use App\Filters\ThreadFilter;
use App\Http\Resources\CommentResource;

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
    public function index(Channel $channel=null,ThreadFilter $filters)
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
        $threads=$threads->with('channel')->latest()->paginate();

       return view('threads.index',compact('threads'));
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
    public function show(Channel $channel,$threadid)
    {

     
        $thread=Thread::where('channel_id',$channel->id)->where('id',$threadid)->first();

     $comments= CommentResource::collection($thread->comments()->latest()->paginate(4)); //!decorator pattern

        if(request()->wantsJson()){
            return $comments;
        }

        return view('threads.show',compact('thread','comments'));
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
    public function destroy(Channel $channel,Thread $thread)
    {
       if(auth()->user()->cannot('update',$thread)){
           abort(403);
       }
        $thread->delete();

        return redirect('/threads');
    }
}
