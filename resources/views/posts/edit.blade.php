@extends('layouts.app')

@section('content')
<h1>Edit Post <a href="/posts/{{$post->id}}">{{$post->title}}</a></h1>
{!! Form::open(['id' => 'postForm', 'action' => ['PostsController@update', $post->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
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
            <img src="/storage/images/cover_images/thumbnails/{{$post->thumbnail}}">
        </p>
        @if($post->cover_image !== 'noimage.jpg')
            <p>
                <a href="" class="btn btn-danger" onclick="
                    event.preventDefault();
                    if(confirm('Remove Cover Image?'))
                    {
                        document.getElementById('cover-image-form').submit();
                    }
                ">
                    Remove Cover Image
                </a>
            </p>
        @endif
        {{Form::file('cover_image')}}
    </div>
    <div class="form-group">
        {{Form::label('images', 'Images')}}
    </div>
    <div class="form-group">
        @foreach($images as $image)
            <div>
                <img class="mr-auto" src="/storage/images/thumbnails/{{$image->filename_thumb}}">
                <a href="" class="btn btn-danger" onclick="
                    event.preventDefault();
                    if(confirm('Remove Image?'))
                    {
                        document.getElementById('image-form-{{$image->id}}').submit();
                    }
                ">
                    X
                </a>
            </div>
        @endforeach
    </div>
    <div class="form-group" id="imageAdderButton">
        <button class="btn btn-default" onclick="event.preventDefault(); addImage()">
            <i class="fas fa-plus fa-fw"></i> Add Image
        </button>
    </div>
    <input type="hidden" name="numberOfImages" id="numberOfImages">
    <div class="form-group">
        {{Form::submit('Submit', ['class' => 'btn btn-primary', 'onclick' => 'sendNumberOfImages()'])}}
    </div>
{!! Form::close() !!}

@if($post->cover_image !== 'noimage.jpg')
    {!! Form::open(['action' => ['PostsController@remove_cover_image'], 'method' => 'POST', 'id' => 'cover-image-form']) !!}
        {{Form::hidden('id', $post->id)}}
    {!! Form::close() !!}
@endif

@foreach($images as $image)
    {!! Form::open(['action' => ['PostsController@remove_image'], 'method' => 'POST', 'id' => 'image-form-' . $image->id]) !!}
        {{Form::hidden('id', $image->id)}}
    {!! Form::close() !!}
@endforeach

@endsection

@section('ckeditor')
<script>
    CKEDITOR.replace( 'article-ckeditor' );
</script>
@endsection
