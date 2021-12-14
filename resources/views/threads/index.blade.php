@extends('layouts.app')

@section('content')
<div class="container">
    
        @foreach ($threads as $thread)
            <div class="card my-2">
                    <div class="card-header">
                        <a href={{$thread->path()}}>
                          {{$thread->title}}
                        </a>
                      
                    </div>
                    <div class="card-body">
                        {{$thread->desc}}
                    </div>
                    <div class="card-footer">
                        {{$thread->created_at->diffForHumans()}}
                    </div>
            </div>
            
        @endforeach
        {{$threads->links()}}
</div>
    
@endsection