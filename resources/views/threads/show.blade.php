@extends('layouts.app')

@section('content')
    <div class="container row">
        <div class=" card  col-md-8 ">
                    
                    <div class="card-body">
                        <div class="card-header d-flex align-item-center">
                        <h1 class="flex-grow-1">
                          {{$thread->title}}
                        </h1>

                        @can('update',$thread)
                        <form action={{route('thread.delete',$thread->id)}} method="post">
                                @csrf
                                @method('DELETE')
                                 <button type="submit" class="btn btn-danger">Delete</button>
                        
                        </form>
                        @endcan
                      
                    </div>
                        {{$thread->desc}}
                    </div>
                    <div class="card-footer">
                        {{$thread->created_at->diffForHumans()}}
                    </div>
                 {{-- <h3>Comment Section</h3>
        
                        <form action={{"/comments/$thread->id"}} method="post" >
                                @csrf
                                <input type="text" class="form-control" name="title">
                                <button class="btn btn-primary my-2">Comment</button>
                                @error('title')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                        </form> 
                          @foreach ($comments as $comment)

                        <div class="card my-2">

                            <div class="card-header d-flex">
                                <h2 class="flex-grow-1">
                                    {{$comment->user->name}}
                                </h2>
                                <form action={{route('comment.favourite',$comment->id)}} method="post">
                                    @csrf
                                    <button class="btn btn-primary">
                                         {{$comment->favourites_count}} Favourited
                                    </button>

                                </form>
                            </div>
                            <div class="card-header d-flex">
                            <h5 class="flex-grow-1">
                                {{$comment->title}}
                            </h5>
                            @can('delete',$comment)
                             <form action={{route('comment.delete',$comment->id)}} method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">
                                          Delete
                                    </button>

                                </form>
                             @endcan

                            </div>
                        </div>
                        @endforeach

                        {{$comments->links()}}
                         --}}
                     
            

               <div id="comments" thread="{{json_encode($thread)}}"></div>
            </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <p>
                                    This thread was create at {{$thread->created_at->diffForHumans()}}
                                    by <a href="{{route('profile',$thread->user->name)}}">{{$thread->user->name}}</a> with {{$thread->comments_count}} replies;
                                </p>
                            </div>
                        </div>
                         <form class="m-2" action="{{route('thread.subscribe',$thread->id)}}" method="POST">
                            @csrf
                            <button class="btn btn-primary">Subscribe</button>
                         </form>
                    </div>
                   
            </div> 

            
                
@endsection