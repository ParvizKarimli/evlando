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

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        @foreach($images as $image)
            <div class="carousel-item">
                <img class="d-block w-100" src="/storage/cover_images/{{$image->filename}}" alt="First slide">
            </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
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
