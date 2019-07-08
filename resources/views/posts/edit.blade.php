@extends('layouts.app')

@section('content')
<h1>Create Post</h1>
{!! Form::open(['action' => ['PostsController@update', $post->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
        {{Form::label('title', 'Title')}}
        {{Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
    </div>
    <div class="form-group">
        {{Form::label('body', 'Body')}}
        {{Form::textarea('body', $post->body, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body'])}}
    </div>
    <div class="form-group">
        {{Form::label('cover_image', 'Cover Image')}}
        <p>
            <img src="/storage/cover_images/thumbnails/{{$post->thumbnail}}">
        </p>
        @if($post->cover_image !== 'noimage.jpg')
            <p>
                <a href="" class="btn btn-danger" onclick="
                    event.preventDefault();
                    if(confirm('Remove Cover Image?'))
                    {
                        document.getElementById('cover-image').submit();
                    }
                ">
                    Remove Cover Image
                </a>
            </p>
        @endif
        {{Form::file('cover_image')}}
    </div>
    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
{!! Form::close() !!}

@if($post->cover_image !== 'noimage.jpg')
    {!! Form::open(['action' => ['PostsController@remove_cover_image'], 'method' => 'POST', 'id' => 'cover-image']) !!}
        {{Form::hidden('id', $post->id)}}
    {!! Form::close() !!}
@endif
@endsection
