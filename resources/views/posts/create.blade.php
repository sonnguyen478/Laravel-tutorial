@extends('layouts.app')

@section('content')
    <h1>Create Post</h1>
    {!! Form::open(['action'=> 'PostsController@store','method' => 'POST']) !!}
        <div class = 'from-group'>
            {{Form::label('title','Title')}}
            {{Form::text('title', '',['class' =>'form-control','placeholder'=>'Tilte'])}}
        </div>  
        <div class = 'from-group'>
                {{Form::label('body','Body')}}
                {{Form::textarea('body', '',['class' =>'form-control','placeholder'=>'Body Text'])}}
        </div>          
        {{Form::submit('Submit',['class'=>'btn btn-promary'])}}
    {!! Form::close() !!}

@endsection