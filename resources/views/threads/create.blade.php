@extends('layouts.app')


@section('content')
<form action="/threads" method="post" class="container form-group card" >
    @csrf
    <div class="card-body">
    <label for="">title</label>
        <input type="text" name="title" class="form-control">
    
        <label for="">Desc</label>

        <input type="text" name="desc" class="form-control">
        <button class="btn btn-primary my-2">Confirm</button>
    </div>
   
</form>
@endsection