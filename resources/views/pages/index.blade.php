@extends('layouts.app')

@section('title', __('pages.home'))

@section('content')
<div class="col-md-4 col-sm-4">
    <!-- Empty space -->
</div>
<div class="col-md-8 col-sm-8">
    <h1>
        {{ __('pages.newest_posts') }}
    </h1>
</div>
<div class="col-md-4 col-sm-4">
    <p>Developed by <a href="https://parvizkarimli.com" target="_blank">Parviz Karimli</a></p>
    <h1>{{ __('pages.search') }}</h1>
    <div class="well">
        {!! Form::open(['action' => 'PostsController@search', 'method' => 'GET']) !!}
            <div class="form-group">
                {!! Form::label('location-input', __('posts.location')) !!}
                {!! Form::text('location', '', [
                    'id' => 'location-input',
                    'class' => 'form-control',
                    'placeholder' => 'New York',
                    'autocomplete' => 'off'
                ]) !!}
                {!! Form::hidden('location_id', '', ['id' => 'location_id']) !!}
            </div>
            <div id="location-suggestions-container"></div>
            <div class="form-group">
                <label for="type">{{ __('posts.type') }}</label>
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('types[]', 'sale') }} {{ __('posts.for_sale') }}
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('types[]', 'rent') !!} {{ __('posts.for_rent') }}
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="property_type">{{ __('posts.property_type') }}</label>
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('property_types[]', 'apartment') }} {{ __('posts.apartment') }}
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('property_types[]', 'house') !!} {{ __('posts.house') }}
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="floor">{{ __('posts.floor') }}</label>
                <div>
                    <label>
                        Min {{ Form::number('floor_min', '', ['class' => 'form-control', 'min' => 1]) }}
                    </label>
                </div>
                <div>
                    <label>
                        Max {{ Form::number('floor_max', '', ['class' => 'form-control', 'min' => 1]) }}
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="area">{{ __('posts.area') }} (ft<sup>2</sup>)</label>
                <div>
                    <label>
                        Min {{ Form::number('area_min', '', ['class' => 'form-control', 'min' => 10]) }}
                    </label>
                </div>
                <div>
                    <label>
                        Max {{ Form::number('area_max', '', ['class' => 'form-control', 'min' => 10]) }}
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="bedrooms">{{ __('posts.bedrooms') }}</label>
                <div>
                    <label>
                        Min {{ Form::number('bedrooms_min', '', ['class' => 'form-control', 'min' => 1]) }}
                    </label>
                </div>
                <div>
                    <label>
                        Max {{ Form::number('bedrooms_max', '', ['class' => 'form-control', 'min' => 1]) }}
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="bathrooms">{{ __('posts.bathrooms') }}</label>
                <div>
                    <label>
                        Min {{ Form::number('bathrooms_min', '', ['class' => 'form-control', 'min' => 1]) }}
                    </label>
                </div>
                <div>
                    <label>
                        Max {{ Form::number('bathrooms_max', '', ['class' => 'form-control', 'min' => 1]) }}
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="price">{{ __('posts.price') }}</label>
                <div>
                    <label>
                        Min {{ Form::number('price_min', '', ['class' => 'form-control', 'min' => 1]) }}
                    </label>
                </div>
                <div>
                    <label>
                        Max {{ Form::number('price_max', '', ['class' => 'form-control', 'min' => 1]) }}
                    </label>
                </div>
            </div>
            <div class="form-group">
                {{Form::submit(__('pages.search_btn'), ['class' => 'btn btn-default'])}}
            </div>
        {!! Form::close() !!}
    </div>
</div>
<div class="col-md-8 col-sm-8 posts-container">
    @if(count($posts) > 0)
        @foreach($posts as $post)
            <div class="well posts-item">
                <div class="row">
                    <div class="container">
                        <div class="col-md-4 col-sm-4">
                            <p class="post-thumb">
                                <a href="/posts/{{$post->id}}/{{$post->slug}}" target="_blank">
                                    <img style="width:100%" src="/storage/images/cover_images/thumbnails/{{$post->thumbnail}}">
                                </a>
                            </p>
                        </div>
                        <div class="col-md-8 col-sm-8"></div>
                    </div>
                    <div>
                        <div>
                            <h1>
                                @if(auth()->user())
                                    @if(in_array($post->id, $bookmarked_posts_ids))
                                        <a href="" title="{{ __('bookmarks.remove') }}" bookmark-post-id="{{$post->id}}"
                                           class="post-to-bookmark no-txt-decor">
                                            &#9733
                                        </a>
                                    @else
                                        <a href="" title="{{ __('bookmarks.bookmark') }}" bookmark-post-id="{{$post->id}}"
                                           class="post-to-bookmark no-txt-decor">
                                            &#9734
                                        </a>
                                    @endif

                                    @if($post->user_id !== auth()->user()->id)
                                        <!-- Trigger the modal with a button -->
                                        <a class="pull-right no-txt-decor" href="" title="{{ __('reports.report_post') }}" data-toggle="modal" data-target="#reportModal-{{$post->id}}">
                                            &#9872
                                        </a>
                            </h1>
                                        <!-- Report Post Modal -->
                                        @include('inc.report_post_modal')
                                    @endif
                                @elseif(auth()->guest())
                                    <a class="no-txt-decor" href="{{route('login')}}" title="{{ __('bookmarks.bookmark') }}">
                                        &#9734
                                    </a>

                                    <a class="pull-right no-txt-decor" href="{{route('login')}}" title="{{ __('reports.report_post') }}">
                                        &#9872
                                    </a>
                                @endif
                        </div>
                        @if($post->type === 'sale')
                            <p class="alert-info">
                                {{ $post->property_type === 'apartment' ? ucfirst(__('posts.apartment')) : ucfirst(__('posts.house')) }}
                                {{ __('posts.for_sale') }}
                            </p>
                        @elseif($post->type === 'rent')
                            <p class="alert-info">
                                {{ $post->property_type === 'apartment' ? ucfirst(__('posts.apartment')) : ucfirst(__('posts.house')) }}
                                {{ __('posts.for_rent') }}
                            </p>
                        @endif
                        <p>
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $post->location->city }}, {{ $post->location->province }}, {{ $post->location->country }}
                        </p>
                        @if($post->property_type === 'apartment')
                            <p>{{ $post->floor }}. {{ __('posts.floor') }}</p>
                        @elseif($post->property_type === 'house')
                            @if($post->floor === 1)
                                <p>1 {{ __('posts.floor') }}</p>
                            @else
                                <p>
                                    {{ $post->floor }}
                                    {{ app()->isLocale('en') ? str_plural(__('posts.floor')) : __('posts.floor') }}
                                </p>
                            @endif
                        @endif
                        <p>{{ $post->area }} {{ __('posts.square_feet') }}</p>
                        @if($post->bedrooms === 1)
                            <p>1 {{ __('posts.bedroom') }}</p>
                        @else
                            <p>
                                {{ $post->bedrooms }} {{ app()->isLocale('en') ? str_plural(__('posts.bedroom')) : __('posts.bedroom') }}
                            </p>
                        @endif
                        @if($post->bathrooms === 1)
                            <p>1 {{ __('posts.bathroom') }}</p>
                        @else
                            <p>
                                {{ $post->bathrooms }} {{ app()->isLocale('en') ? str_plural(__('posts.bathroom')) : __('posts.bathroom') }}
                            </p>
                        @endif
                        @if($post->type === 'sale')
                            <p>${{ number_format($post->price) }}</p>
                        @elseif($post->type === 'rent')
                            <p>${{ number_format($post->price) }}/{{ __('posts.month') }}</p>
                        @endif
                        <div>
                            <b>{{ __('posts.description') }}:</b><br>
                            {{ str_limit($post->description, $limit = 150, $end = '...') }}
                            @if(strlen($post->description) > 150)
                                <a href="/posts/{{$post->id}}/{{$post->slug}}" target="_blank">
                                    {{ __('posts.read_more') }}
                                </a>
                            @endif
                        </div>
                        <small>
                            {!! __(
                                    'posts.created_at_by',
                                    [
                                        'at' => $post->created_at,
                                        'by' => link_to('/users/' . $post->user->id, $post->user->name)
                                    ]
                                )
                            !!}
                        </small>
                    </div>
                </div>
            </div>
        @endforeach
        {{$posts->links()}}
    @else
        <p>{{ __('pages.no_posts_found') }}</p>
    @endif
</div>

<div class="page-load-status text-center">
    @if($number_of_active_posts > 10)
        <p class="infinite-scroll-request">
            {{ __('pages.loading') }}...<br>
            <img src="/storage/images/default/loader.svg">
        </p>
    @endif
    <p class="infinite-scroll-last">{{ __('pages.end_of_content') }}</p>
    @if(!$posts)
        <p class="infinite-scroll-error">{{ __('pages.no_more_pages_to_load') }}</p>
    @endif
</div>
@endsection

@if($number_of_active_posts > 10)
    @section('infinite_scroll')
    <script>
        if(document.querySelector('.pagination')) {
            $('.posts-container').infiniteScroll({
                // options
                path: '.pagination li.active + li a',
                append: '.posts-item',
                history: false,
                hideNav: '.pagination',
                status: '.page-load-status'
            });
        }
    </script>
    @endsection
@endif
