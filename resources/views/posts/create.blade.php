@extends('layouts.app')

@section('content')
<h1>Create Post</h1>
{!! Form::open(['id' => 'postForm', 'action' => 'PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
        {{Form::label('title', 'Title')}}
        {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
    </div>
    <div class="form-group">
        {{Form::label('body', 'Body')}}
        {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body'])}}
    </div>
    <div class="form-group">
        {{Form::label('cover_image', 'Cover Image')}}
        {{Form::file('cover_image')}}
    </div>
    <div class="form-group">
        {{Form::label('images', 'Images')}}
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
@endsection

@section('ckeditor')
<script>
    CKEDITOR.replace( 'article-ckeditor' );
</script>
@endsection
