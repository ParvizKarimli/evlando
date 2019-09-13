@extends('layouts.app')

@section('title', __('users.users') . ' - ' . $user->name)

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>
                    {{$user->name}}

                    @if($user->id !== auth()->user()->id)
                        <!-- Trigger the modal with a button -->
                        <a class="no-txt-decor" href="" title="{{ __('reports.report_user') }}" data-toggle="modal" data-target="#reportModal-{{$user->id}}">
                            &#9872
                        </a>
                    @endif
                </h1>

                <!-- Report User Modal -->
                @include('inc.report_user_modal')
            </div>

            <div class="panel-body">
                @if($user->banned === 1)
                    <div>
                        <img src="/storage/images/default/suspended-1.jpg">
                    </div>
                @endif

                <h3>{{ __('posts.posts_by', ['u' => $user->name]) }}</h3>
                @if(count($posts) > 0)
                    @foreach($posts as $post)
                        @if($post->suspended === 0)
                            <div class="well">
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
                                            {{ $post->description }}
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
                        @endif
                    @endforeach
                    {{$posts->links()}}
                @else
                    <p>{{ __('posts.no_posts_found') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
