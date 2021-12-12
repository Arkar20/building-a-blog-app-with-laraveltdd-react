@extends('layouts.app')

@section('content')
    <div class="container">
        <div class=" card  ">
                    <div class="card-header">
                        <h1 href={{"/threads/{$thread->id}"}}>
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
@endsection