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

<div class="well">
    <div id="postCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#postCarousel" data-slide-to="0" class="active"></li>
            @for($i=1; $i<=$number_of_images; $i++)
                <li data-target="#postCarousel" data-slide-to="{{$i}}"></li>
            @endfor
        </ol>
        <div class="carousel-inner">
            <div class="item active">
                <img class="d-block w-100" src="/storage/cover_images/{{$post->cover_image}}" alt="First slide">
            </div>
            @foreach($images as $image)
                <div class="item">
                    <img class="d-block w-100" src="/storage/cover_images/{{$image->filename}}" alt="First slide">
                </div>
            @endforeach
        </div>
        <a class="left carousel-control" href="#postCarousel" data-slide="prev">
            <i class="fas fa-chevron-left"></i>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#postCarousel" data-slide="next">
            <i class="fas fa-chevron-right"></i>
            <span class="sr-only">Next</span>
        </a>
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
