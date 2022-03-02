@extends('layouts.app')

@section('content')
<div class="container row">

        <div class="col-md-8 my-2">
                @include('threads._list',['threads'=>$threads])

        </div>
        <div class="card col-md-4 ">

                <div id="search"></div>

                <div class="my-2">
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
        </div>

        {{$threads->withQueryString()->links()}}
</div>

@endsection