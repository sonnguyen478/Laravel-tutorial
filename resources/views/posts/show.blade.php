@extends('layouts.app')

@section('content')
    <a href="/posts" class = "btn btn-secondary my-2">Go back</a>
    <h1>{{$post->title}}</h1>
    <div>
        {!!$post->contain!!}
    </div>
    <hr>
    <small>Written on {{$post->created_ate}}</small>
@endsection