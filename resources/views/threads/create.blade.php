@extends('layouts.app')

@section('head')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

@endsection

@section('content')

    <div class="container card">
        @foreach($errors->all() as $error)
            
        <p class="text-danger">{{$error}}</p>

        @endforeach
    </div>

<form action="/threads" method="post" class="container form-group card" >
    @csrf

    <div class="card-body">
    <label for="">title</label>
        <input type="text" name="title" class="form-control">
    
        <label for="">Desc</label>

        <input type="text" name="desc" class="form-control">
      
      
        <label for="">Choose A Chanel</label>

        <select name="channel_id" id="channel" class="form-control">
            @foreach (App\Models\Channel::all() as $channel)
                <option value="{{$channel->id}}">{{$channel->name}}</option>
            @endforeach
        </select>
     <div class="g-recaptcha" data-sitekey="6LcUPwIeAAAAAI6VKwATy-RikEG2nN_DSL6w-pVy"></div>

        <button class="btn btn-primary my-2">Confirm</button>
    </div>
   
</form>
@endsection