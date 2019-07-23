@extends('layouts.app')

@section('content')
<h1>Edit Post <a class="btn btn-default" href="/posts/{{$post->id}}/{{$post->slug}}">Back to the post</a></h1>
{!! Form::open(['id' => 'post-form', 'action' => ['PostsController@update', $post->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group {{ $errors->has('location_id') ? 'has-error' : '' }}">
        {{Form::label('location-input', 'Location')}}
        {{Form::text('location', $post->location->city . ', ' . $post->location->province . ', ' . $post->location->country,
        ['id' => 'location-input', 'class' => 'form-control', 'placeholder' => 'New York', 'autocomplete' => 'off', 'required' => 'required'])}}
        {!! Form::hidden('location_id', $post->location_id, ['id' => 'location_id']) !!}
        @if($errors->has('location_id'))
            <span class="help-block">
                <strong>{{ $errors->first('location_id') }}</strong>
            </span>
        @endif
    </div>
    <div id="location-suggestions-container"></div>
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
    <div class="form-group {{ $errors->has('property_type') ? 'has-error' : '' }}">
        <label for="property_type">Property Type</label>
        <div class="radio">
            <label>
                {{Form::radio('property_type', 'apartment', $post->property_type === 'apartment' ? ['checked'] : '')}} Apartment
            </label>
        </div>
        <div class="radio">
            <label>
                {{Form::radio('property_type', 'house', $post->property_type === 'house' ? ['checked'] : '')}} House
            </label>
        </div>
        @if($errors->has('property_type'))
            <span class="help-block">
                <strong>{{ $errors->first('property_type') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('floor') ? 'has-error' : '' }}">
        {{Form::label('floor', 'Floor')}}
        <div>
            {{Form::number('floor', $post->floor, ['min' => 1, 'required' => 'required'])}}
        </div>
        @if($errors->has('floor'))
            <span class="help-block">
                <strong>{{ $errors->first('floor') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('area') ? 'has-error' : '' }}">
        {{Form::label('area', 'Area')}}
        <div>
            {{Form::number('area', $post->area, ['min' => 10, 'required' => 'required'])}} ft<sup>2</sup>
        </div>
        @if($errors->has('area'))
            <span class="help-block">
                <strong>{{ $errors->first('area') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('bedrooms') ? 'has-error' : '' }}">
        {{Form::label('bedrooms', 'Bedrooms')}}
        <div>
            {{Form::number('bedrooms', $post->bedrooms, ['min' => 1, 'required' => 'required'])}}
        </div>
        @if($errors->has('bedrooms'))
            <span class="help-block">
                <strong>{{ $errors->first('bedrooms') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('bathrooms') ? 'has-error' : '' }}">
        {{Form::label('bathrooms', 'Bathrooms')}}
        <div>
            {{Form::number('bathrooms', $post->bathrooms, ['min' => 1, 'required' => 'required'])}}
        </div>
        @if($errors->has('bathrooms'))
            <span class="help-block">
                <strong>{{ $errors->first('bathrooms') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
        {{Form::label('price', 'Price')}}
        <div>
            $ {{Form::number('price', $post->price, ['min' => 1, 'required' => 'required'])}}
            @if($post->type === 'rent')
                /month
            @endif
        </div>
        @if($errors->has('price'))
            <span class="help-block">
                <strong>{{ $errors->first('price') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
        {{Form::label('description', 'Description')}}
        {{Form::textarea('description', $post->description, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'description', 'required' => 'required'])}}
        @if($errors->has('description'))
            <span class="help-block">
                <strong>{{ $errors->first('description') }}</strong>
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
        <button class="btn btn-default" id="image-adder-button">
            <i class="fas fa-plus fa-fw"></i> Add Image
        </button>
    </div>
    <input type="hidden" name="numberOfImages" id="numberOfImages">
    <div class="form-group">
        {{Form::submit('Submit', ['class' => 'btn btn-primary', 'id' => 'number-of-images-sender'])}}
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
