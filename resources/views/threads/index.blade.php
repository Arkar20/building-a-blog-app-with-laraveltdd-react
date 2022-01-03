@extends('layouts.app')

@section('content')
<div class="container row">
    
        <div class="col-md-8 card my-2">
       @include('threads._list',['threads'=>$threads])

        </div>

        <div class="col-md-4 ">
                <h3>Trending Threads</h3>
                <ul class="list-group">
                        @foreach ($trending_threads as $count=>$trending)

                        <li class="list-group-item d-flex justify-content-between">
                                <a href="">{{$trending->title}}</a>
                                <p>Total Views {{$count}}</p>
                        </li>
                        @endforeach
                </ul>
        </div>
       
        {{$threads->withQueryString()->links()}}
</div>
    
@endsection