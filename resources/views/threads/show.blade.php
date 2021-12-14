@extends('layouts.app')

@section('content')
    <div class="container">
        <div class=" card  ">
                    <div class="card-header">
                        <h1>
                          {{$thread->title}}
                        </h1>
                      
                    </div>
                    <div class="card-body">
                        {{$thread->desc}}
                    </div>
                    <div class="card-footer">
                        {{$thread->created_at->diffForHumans()}}
                    </div>
            </div>
            </div>
            <div class="container">
                <h3>Comment Section</h3>

                <form action={{"/comments/$thread->id"}} method="post">
                        @csrf
                        <input type="text" class="form-control" name="title">
                        <button class="btn btn-primary my-2">Comment</button>
                </form>
                @foreach ($thread->comments as $comment)
                <div class="card my-2">
                    <div class="card-header">
                        {{$comment->title}}
                    </div>
                </div>
                @endforeach
            </div>
@endsection