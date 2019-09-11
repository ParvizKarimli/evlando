@extends('layouts.adminpanel.app')

@section('title', __('posts.create_post'))

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{ __('posts.create_post') }}</div>

    <div class="panel-body">
        {!! Form::open(['id' => 'post-form', 'action' => 'PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group {{ $errors->has('location_id') ? 'has-error' : '' }}">
                {{Form::label('location-input', __('posts.location'))}}
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
                <label for="type">{{ __('posts.type') }}</label>
                <div class="radio">
                    <label>
                        {{Form::radio('type', 'sale')}} {{ __('posts.for_sale') }}
                    </label>
                </div>
                <div class="radio">
                    <label>
                        {{Form::radio('type', 'rent')}} {{ __('posts.for_rent') }}
                    </label>
                </div>
                @if($errors->has('type'))
                    <span class="help-block">
                        <strong>{{ $errors->first('type') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('property_type') ? 'has-error' : '' }}">
                <label for="property_type">{{ __('posts.property_type') }}</label>
                <div class="radio">
                    <label>
                        {{Form::radio('property_type', 'apartment')}} {{ __('posts.apartment') }}
                    </label>
                </div>
                <div class="radio">
                    <label>
                        {{Form::radio('property_type', 'house')}} {{ __('posts.house') }}
                    </label>
                </div>
                @if($errors->has('property_type'))
                    <span class="help-block">
                        <strong>{{ $errors->first('property_type') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('floor') ? 'has-error' : '' }}">
                {{Form::label('floor', __('posts.floor'))}}
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
                {{Form::label('area', __('posts.area'))}}
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
                {{Form::label('bedrooms', __('posts.bedrooms'))}}
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
                {{Form::label('bathrooms', __('posts.bathrooms'))}}
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
                {{Form::label('price', __('posts.price'))}}
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
                {{Form::label('description', __('posts.description'))}}
                {{
                    Form::textarea(
                        'description', '',
                        [
                            'class' => 'form-control',
                            'placeholder' => __('posts.description'),
                            'required' => 'required'
                        ]
                    )
                }}
                @if($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('cover_image') ? 'has-error' : '' }}">
                {{Form::label('cover_image', __('posts.cover_image'))}}
                {{Form::file('cover_image', '', ['accept' => '.jpg, .jpeg, .png, .gif'])}}
                @if($errors->has('cover_image'))
                    <span class="help-block">
                        <strong>{{ $errors->first('cover_image') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                {{Form::label('images', __('posts.images'))}}
            </div>
            <div class="form-group" id="imageAdderButton">
                <button class="btn btn-default" id="image-adder-button">
                    <i class="fas fa-plus fa-fw"></i> {{ __('posts.add_image') }}
                </button>
            </div>
            <input type="hidden" name="numberOfImages" id="numberOfImages">
            <div class="form-group">
                {{Form::submit(__('posts.create'), ['class' => 'btn btn-primary', 'id' => 'number-of-images-sender'])}}
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
