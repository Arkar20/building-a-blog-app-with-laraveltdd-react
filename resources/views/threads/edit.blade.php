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

<form action="{{$thread->path()}}" method="post" class="container form-group card" >
    @csrf
    @method('PATCH')

    <div class="card-body">
    <label for="">title</label>
        <input type="text" name="title" class="form-control" value={{$thread->title}}>
    
        <label for="">Desc</label>

        <input type="text" name="desc" class="form-control" value={{$thread->desc}}>
      
      
        <label for="">Choose A Chanel</label>

        <select name="channel_id" id="channel" class="form-control">
            @foreach (App\Models\Channel::all() as $channel)
                <option value="{{$channel->id}}" @if($channel->id==$thread->channel_id) selected @endif>
                  {{$channel->name}}
                </option>
            @endforeach
        </select>

     <div class="g-recaptcha" data-sitekey="6LcUPwIeAAAAAI6VKwATy-RikEG2nN_DSL6w-pVy"></div>

        <button class="btn btn-primary my-2">Confirm</button>
    </div>
   
</form>
@endsection