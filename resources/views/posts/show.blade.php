@extends('layouts.app')

@section('content')
<div class="well">
    <div class="row">
        <div class="col-md-4 col-sm-4">
            <img style="width:100%" src="/storage/cover_images/{{$post->cover_image}}">
        </div>
        <div class="col-md-8 col-sm-8">
            <h1>{{$post->title}}</h1>
            <small>Created at {{$post->created_at}} by {{$post->user->name}}</small>
            <div>{!!$post->body!!}</div>
        </div>
    </div>
</div>
<hr>
@if(!Auth::guest() && Auth::user()->id === $post->user_id)
    <a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>

    <a class="btn btn-danger pull-right" href="" onclick="
        event.preventDefault();
        if(confirm('Delete post?')) {
            document.getElementById('post-{{$post->id}}').submit();
        }
    ">
        Delete
    </a>
    {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'DELETE', 'id' => 'post-' . $post->id]) !!}
    {!! Form::close() !!}
@endif
@endsection
