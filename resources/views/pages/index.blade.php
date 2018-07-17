@extends('layouts.app')


@section('content')
    <section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading">{{$title}}</h1>
        <p class="lead text-muted">This is my first laravel project that make from learning the online course.</p>
        <p>
        <a href="{{ route('login') }}" class="btn btn-primary my-2">Login</a>
        <a href="{{ route('register') }}" class="btn btn-secondary my-2">Register</a>
        </p>
    </div>
    </section>    
@endsection
