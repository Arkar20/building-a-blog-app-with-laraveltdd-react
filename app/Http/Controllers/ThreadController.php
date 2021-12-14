<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Channel;
use Illuminate\Http\Request;
use App\Http\Requests\ThreadRequest;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel)
    {
        if($channel->name){
            // dd("Channel");
              return view('threads.index',['threads'=>$channel->threads()->paginate(10)]);

        }
       return view('threads.index',['threads'=>Thread::latest()->paginate(20)]);
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
        Thread::create(['title'=>$request->get('title'),'desc'=>$request->get('desc'),'user_id'=>auth()->id(),'channel_id'=>$request->channel_id]);

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

        // dd($channel);
        $thread=Thread::where('channel_id',$channel->id)->where('id',$threadid)->first();

        
        return view('threads.show',compact('thread'));
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
        //
    }
}
