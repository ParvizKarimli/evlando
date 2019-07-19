@extends('layouts.app')

@section('content')
<h1>Create Post</h1>
{!! Form::open(['id' => 'post-form', 'action' => 'PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
        <label for="type">Type</label>
        <div class="radio">
            <label>
                {{Form::radio('type', 'sale')}} For Sale
            </label>
        </div>
        <div class="radio">
            <label>
                {{Form::radio('type', 'rent')}} For Rent
            </label>
        </div>
        @if($errors->has('type'))
            <span class="help-block">
                <strong>{{ $errors->first('type') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('property_type') ? 'has-error' : '' }}">
        <label for="property_type">Property Type</label>
        <div class="radio">
            <label>
                {{Form::radio('property_type', 'apartment')}} Apartment
            </label>
        </div>
        <div class="radio">
            <label>
                {{Form::radio('property_type', 'house')}} House
            </label>
        </div>
        @if($errors->has('property_type'))
            <span class="help-block">
                <strong>{{ $errors->first('property_type') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
        {{Form::label('title', 'Title')}}
        {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title', 'required' => 'required'])}}
        @if($errors->has('title'))
            <span class="help-block">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
        {{Form::label('body', 'Body')}}
        {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body', 'required' => 'required'])}}
        @if($errors->has('body'))
            <span class="help-block">
                <strong>{{ $errors->first('body') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('cover_image') ? 'has-error' : '' }}">
        {{Form::label('cover_image', 'Cover Image')}}
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
