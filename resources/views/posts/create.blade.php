@extends('layouts.app')

@section('content')
<h1>Create Post</h1>
{!! Form::open(['id' => 'post-form', 'action' => 'PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group {{ $errors->has('location_id') ? 'has-error' : '' }}">
        {{Form::label('location-input', 'Location')}}
        {{Form::text('location', '',
        ['id' => 'location-input', 'class' => 'form-control', 'placeholder' => 'New York', 'autocomplete' => 'off', 'required' => 'required'])}}
        {!! Form::hidden('location_id', '', ['id' => 'location_id']) !!}
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
    <div class="form-group {{ $errors->has('floor') ? 'has-error' : '' }}">
        {{Form::label('floor', 'Floor')}}
        <div>
            {{Form::number('floor', '', ['min' => 1, 'max' => 1000, 'required' => 'required'])}}
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
            {{Form::number('area', '', ['min' => 10, 'max' => 100000, 'required' => 'required'])}} ft<sup>2</sup>
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
            {{Form::number('bedrooms', '', ['min' => 1, 'max' => 1000, 'required' => 'required'])}}
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
            {{Form::number('bathrooms', '', ['min' => 1, 'max' => 100, 'required' => 'required'])}}
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
            $ {{Form::number('price', '', ['min' => 1, 'max' => 1000000000, 'required' => 'required'])}}
        </div>
        @if($errors->has('price'))
            <span class="help-block">
                <strong>{{ $errors->first('price') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
        {{Form::label('description', 'Description')}}
        {{Form::textarea('description', '', ['class' => 'form-control', 'placeholder' => 'description', 'required' => 'required'])}}
        @if($errors->has('description'))
            <span class="help-block">
                <strong>{{ $errors->first('description') }}</strong>
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
        <button class="btn btn-default" id="image-adder-button">
            <i class="fas fa-plus fa-fw"></i> Add Image
        </button>
    </div>
    <input type="hidden" name="numberOfImages" id="numberOfImages">
    <div class="form-group">
        {{Form::submit('Submit', ['class' => 'btn btn-primary', 'id' => 'number-of-images-sender'])}}
    </div>
{!! Form::close() !!}
@endsection
