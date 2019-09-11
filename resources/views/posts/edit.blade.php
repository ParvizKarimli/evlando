@extends('layouts.adminpanel.app')

@section('title', __('posts.edit_post') . ' - ' . $post->slug)

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <p>{{ __('posts.edit_post') }}</p>
        <a class="btn btn-default" href="/posts/{{$post->id}}/{{$post->slug}}">
            &#8592; {{ __('posts.go_back') }}
        </a>
    </div>

    <div class="panel-body">
        {!! Form::open(['id' => 'post-form', 'action' => ['PostsController@update', $post->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group {{ $errors->has('location_id') ? 'has-error' : '' }}">
                {{Form::label('location-input', __('posts.location'))}}
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
                <label for="type">{{ __('posts.type') }}</label>
                <div class="radio">
                    <label>
                        {{Form::radio('type', 'sale', $post->type === 'sale' ? ['checked'] : '')}} {{ __('posts.for_sale') }}
                    </label>
                </div>
                <div class="radio">
                    <label>
                        {{Form::radio('type', 'rent', $post->type === 'rent' ? ['checked'] : '')}} {{ __('posts.for_rent') }}
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
                        {{Form::radio('property_type', 'apartment', $post->property_type === 'apartment' ? ['checked'] : '')}} {{ __('posts.apartment') }}
                    </label>
                </div>
                <div class="radio">
                    <label>
                        {{Form::radio('property_type', 'house', $post->property_type === 'house' ? ['checked'] : '')}} {{ __('posts.house') }}
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
                    {{Form::number('floor', $post->floor, ['min' => 1, 'max' => 1000, 'required' => 'required'])}}
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
                    {{Form::number('area', $post->area, ['min' => 10, 'max' => 100000, 'required' => 'required'])}} ft<sup>2</sup>
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
                    {{Form::number('bedrooms', $post->bedrooms, ['min' => 1, 'max' => 1000, 'required' => 'required'])}}
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
                    {{Form::number('bathrooms', $post->bathrooms, ['min' => 1, 'max' => 100, 'required' => 'required'])}}
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
                    $ {{Form::number('price', $post->price, ['min' => 1, 'max' => 1000000000, 'required' => 'required'])}}
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
                {{Form::label('description', __('posts.description'))}}
                {{Form::textarea('description', $post->description, ['class' => 'form-control', 'placeholder' => __('posts.description'), 'required' => 'required'])}}
                @if($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('cover_image') ? 'has-error' : '' }}">
                {{Form::label('cover_image', __('posts.cover_image'))}}
                <p>
                    <img src="/storage/images/cover_images/thumbnails/{{$post->thumbnail}}">
                </p>
                @if($post->cover_image !== 'noimage.jpg')
                    <p>
                        <a href="" class="btn btn-danger" onclick="
                            event.preventDefault();
                            if(confirm('{{ __("posts.remove_cover_image_question") }}'))
                            {
                                document.getElementById('cover-image-form').submit();
                            }
                        ">
                            {{ __('posts.remove_cover_image') }}
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
                {{Form::label('images', __('posts.images'))}}
            </div>
            <div class="form-group">
                @foreach($images as $image)
                    <div>
                        <img class="mr-auto" src="/storage/images/thumbnails/{{$image->filename_thumb}}">
                        <a href="" class="btn btn-danger" onclick="
                            event.preventDefault();
                            if(confirm('{{ __("posts.remove_image_question") }}'))
                            {
                                document.getElementById('image-form-{{$image->id}}').submit();
                            }
                        ">
                            &times;
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="form-group" id="imageAdderButton">
                <button class="btn btn-default" id="image-adder-button">
                    <i class="fas fa-plus fa-fw"></i> {{ __('posts.add_image') }}
                </button>
            </div>
            <input type="hidden" name="numberOfImages" id="numberOfImages">
            <div class="form-group">
                {{Form::submit(__('posts.update'), ['class' => 'btn btn-primary', 'id' => 'number-of-images-sender'])}}
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
    </div>
</div>
@endsection
