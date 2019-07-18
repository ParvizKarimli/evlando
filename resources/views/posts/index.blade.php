@extends('layouts.app')

@section('content')
<div class="col-md-2 col-sm-2">
    <h1>Search</h1>
</div>
<div class="col-md-10 col-sm-10">
    <h1>
        Posts
        <label for="type">Type:</label>
        <select name="type" site="posts" onchange="typeChange(this)">
            <option value="all">All</option>
            <option value="sale">For Sale</option>
            <option value="rent">For Rent</option>
        </select>
    </h1>
</div>
<div class="col-md-2 col-sm-2">
    <div class="well">
        {!! Form::open(['action' => 'PostsController@search', 'method' => 'GET']) !!}
            <div class="form-group">
                {!! Form::label('property_type', 'Property Type') !!}
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('property_type', 'apartment') }} Apartment
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('property_type', 'house') !!} House
                    </label>
                </div>
            </div>
            <div class="form-group">
                {{Form::submit('Search', ['class' => 'btn btn-default'])}}
            </div>
        {!! Form::close() !!}
    </div>
</div>
<div class="col-md-10 col-sm-10">
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
                        @if($post->type === 'sale')
                            <p class="alert-info">For Sale</p>
                        @elseif($post->type === 'rent')
                            <p class="alert-info">For Rent</p>
                        @endif
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
        {{$posts->links()}}
    @else
        <p>No posts found.</p>
    @endif
</div>
@endsection
