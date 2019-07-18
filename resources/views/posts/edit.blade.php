@extends('layouts.app')

@section('content')
<h1>Edit Post <a href="/posts/{{$post->id}}">{{$post->title}}</a></h1>
{!! Form::open(['id' => 'post-form', 'action' => ['PostsController@update', $post->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
        <label for="type">Type</label>
        <div class="radio">
            <label>
                {{Form::radio('type', 'sale', $post->type === 'sale' ? ['checked'] : '')}} For Sale
            </label>
        </div>
        <div class="radio">
            <label>
                {{Form::radio('type', 'rent', $post->type === 'rent' ? ['checked'] : '')}} For Rent
            </label>
        </div>
        @if($errors->has('type'))
            <span class="help-block">
                <strong>{{ $errors->first('type') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
        {{Form::label('title', 'Title')}}
        {{Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Title', 'required' => 'required'])}}
        @if($errors->has('title'))
            <span class="help-block">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
        {{Form::label('body', 'Body')}}
        {{Form::textarea('body', $post->body, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body', 'required' => 'required'])}}
        @if($errors->has('body'))
            <span class="help-block">
                <strong>{{ $errors->first('body') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('cover_image') ? 'has-error' : '' }}">
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
        {{Form::file('cover_image', '', ['accept' => '.jpg, .jpeg, .png, .gif'])}}
        @if($errors->has('cover_image'))
            <span class="help-block">
                <strong>{{ $errors->first('cover_image') }}</strong>
            </span>
        @endif
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
