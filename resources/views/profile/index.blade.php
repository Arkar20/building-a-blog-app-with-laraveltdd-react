{{-- <h1>{{$user->name}}</h1>
@foreach ($threads as $thread)
    <h2>{{$thread->title}}</h2>
    <h2>{{$thread->desc}}</h2>
@endforeach --}}

@extends('layouts.app')


@section('content')

    <div class="container">
        <h1>{{$user->name}}</h1>
    </div>

    <hr class="container">
<div class="row gap-2">
@foreach ($threads as $thread)

    <div class="card col-md-8 offset-md-2" >
        <div class="card-body">
            <h5 class="card-title">{{$thread->title}}</h5>
            <p class="card-text">{{$thread->desc}}</p>
            <p>{{$thread->created_at->diffForHumans()}}</p>
            <a href="{{$thread->path()}}" class="btn btn-primary">View Detail</a>
        </div>
    </div>

@endforeach
        <div class="col-md-8 offset-md-2">

            {{$threads->links()}}
        </div>

</div>

@endsection