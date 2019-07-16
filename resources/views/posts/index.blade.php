@extends('layouts.app')

@section('content')
<h1>Posts</h1>
@if(count($posts) > 0)
    @foreach($posts as $post)
        <div class="well">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <img style="width:100%" src="/storage/images/cover_images/thumbnails/{{$post->thumbnail}}">
                </div>
                <div class="col-md-8 col-sm-8">
                    <h3>
                        <a href="posts/{{$post->id}}">
                            {{$post->title}}
                        </a>
                        @if(auth()->user())
                            @if($bookmarked[$post->id] === false)
                                <a href="" title="Bookmark this post" bookmark-post-id="{{$post->id}}" onclick="bookmarkPost(this);">
                                    <i class="far fa-star"></i>
                                </a>
                            @elseif($bookmarked[$post->id] === true)
                                <a href="" title="Remove this post from bookmarks" bookmark-post-id="{{$post->id}}" onclick="bookmarkPost(this);">
                                    <i class="fas fa-star"></i>
                                </a>
                            @endif
                        @elseif(auth()->guest())
                            <a href="{{route('login')}}" title="Bookmark this post">
                                <i class="far fa-star"></i>
                            </a>
                        @endif
                    </h3>
                    <small>
                        Created at {{$post->created_at}} by {{$post->user->name}}
                    </small>
                    <div>
                        {!! str_limit($post->body, $limit = 150, $end = '...') !!}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{$bookmarks->links()}}
@else
    <p>No posts found.</p>
@endif
@endsection
