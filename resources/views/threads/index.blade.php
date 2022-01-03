@extends('layouts.app')

@section('content')
<div class="container row">
    
       @include('threads._list',['threads'=>$threads])
       
        {{$threads->withQueryString()->links()}}
</div>
    
@endsection