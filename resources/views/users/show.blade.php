@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">{{$user->name}}</div>

            <div class="panel-body">

                <h3>Posts of {{$user->name}}</h3>
                @if(count($posts) > 0)
                    @foreach($posts as $post)
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
                                <h3>
                                    @if(auth()->user())
                                        @if(in_array($post->id, $bookmarked_posts_ids))
                                            <a href="" title="Remove this post from bookmarks" bookmark-post-id="{{$post->id}}"
                                               class="post-to-bookmark">
                                                <i class="fas fa-star"></i>
                                            </a>
                                        @else
                                            <a href="" title="Bookmark this post" bookmark-post-id="{{$post->id}}"
                                               class="post-to-bookmark">
                                                <i class="far fa-star"></i>
                                            </a>
                                        @endif
                                    @elseif(auth()->guest())
                                        <a href="{{route('login')}}" title="Bookmark this post">
                                            <i class="far fa-star"></i>
                                        </a>
                                    @endif
                                </h3>
                                @if($post->type === 'sale')
                                    <p class="alert-info">{{ucfirst($post->property_type)}} For Sale</p>
                                @elseif($post->type === 'rent')
                                    <p class="alert-info">{{ucfirst($post->property_type)}} For Rent</p>
                                @endif
                                <p>
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $post->location->city }}, {{ $post->location->province }}, {{ $post->location->country }}
                                </p>
                                @if($post->property_type === 'apartment')
                                    <p>{{ $post->floor }}. floor</p>
                                @elseif($post->property_type === 'house')
                                    @if($post->floor === 1)
                                        <p>1 floor</p>
                                    @else
                                        <p>{{ $post->floor }} floors</p>
                                    @endif
                                @endif
                                <p>{{ $post->area }} square feet</p>
                                @if($post->bedrooms === 1)
                                    <p>1 bedroom</p>
                                @else
                                    <p>{{ $post->bedrooms }} bedrooms</p>
                                @endif
                                @if($post->bathrooms === 1)
                                    <p>1 bathroom</p>
                                @else
                                    <p>{{ $post->bathrooms }} bathrooms</p>
                                @endif
                                @if($post->type === 'sale')
                                    <p>${{ number_format($post->price) }}</p>
                                @elseif($post->type === 'rent')
                                    <p>${{ number_format($post->price) }}/month</p>
                                @endif
                                <div>
                                    <b>Description:</b><br>
                                    {{ str_limit($post->description, $limit = 150, $end = '...') }}
                                    @if(strlen($post->description) > 150)
                                        <a href="/posts/{{$post->id}}/{{$post->slug}}" target="_blank">
                                            Read More
                                        </a>
                                    @endif
                                </div>
                                <small>
                                    Created at {{$post->created_at}}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    {{$posts->links()}}
                @else
                    <p>No posts found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
