
@extends('layouts.app')


@section('content')

    <div class="container">
        <h1>{{$user->name}}</h1>
    </div>

    <hr class="container">
<div class="row gap-2 container col-8">
@foreach ($activities as $date => $activity)

    <h2 class="container">{{$date}}</h2>

    @foreach ($activity as $record)
        @include('profile.showactivity',['activity'=>$record])
    @endforeach

@endforeach
        <div class="col-md-8 offset-md-2">

            {{-- {{$threads->links()}} --}}
        </div>

</div>

@endsection