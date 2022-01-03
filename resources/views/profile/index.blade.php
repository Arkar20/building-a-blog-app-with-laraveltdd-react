
@extends('layouts.app')


@section('content')

    {{-- <div class="container d-flex align-items-md-center">
        <img src="{{asset(auth()->user()->getAvatar())}}" width="100" height="100" />
        <h1>{{$user->name}}</h1>

    </div>
    @if(auth()->check())
        <form action="{{route('avatar.upload',auth()->user()->name)}}" method="POST" class="container form-group" enctype="multipart/form-data">
                @csrf

            <input type="file" name='avatar'>
            <button type="submit" class="btn btn-success">Upload Profile</button>
            @error('avatar')
            <p>{{$message}}</p>
            @enderror

        </form>
    @endif --}}

        <div id="avatar" authuser="{{json_encode(auth()->user())}}"></div>
  
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