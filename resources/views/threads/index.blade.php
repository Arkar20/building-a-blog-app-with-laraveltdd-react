@extends('layouts.app')

@section('content')
<div class="container row">
    
        @foreach ($threads as $thread)
            <div class="col-md-8 card my-2">
                    <div class="card-header">
                        <a href={{$thread->path()}}>
                          {{$thread->title}}
                        </a>
                      
                    </div>
                    <div class="card-body">
                        {{$thread->desc}}
                    </div>
                    <div class="card-footer">
                        <p>
                            {{$thread->created_at->diffForHumans()}}
                        </p>
                        <p>
                            {{$thread->comments_count}} comments
                        </p>
                    </div>
            </div>
            
        @endforeach
        {{$threads->links()}}
</div>
    
@endsection