@extends('layouts.app')

@section('content')
<div class="col-md-2 col-sm-2">
    <!-- Empty space -->
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
    <h1>Search</h1>
    <div class="well">
        {!! Form::open(['action' => 'PostsController@search', 'method' => 'GET']) !!}
            <div class="form-group">
                <label for="type">Type</label>
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('types[]', 'sale') }} For Sale
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('types[]', 'rent') !!} For Rent
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="property_type">Property Type</label>
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('property_types[]', 'apartment') }} Apartment
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('property_types[]', 'house') !!} House
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="floor">Floor</label>
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
                <label for="area">Area (m<sup>2</sup>)</label>
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
                <label for="bedrooms">Bedrooms</label>
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
                <label for="bathrooms">Bathrooms</label>
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
                            <a href="/posts/{{$post->id}}">
                                {{$post->title}}
                            </a>
                            @if(auth()->user())
                                @if(in_array($post->id, $bookmarked_posts_ids))
                                    <a href="" title="Remove this post from bookmarks" bookmark-post-id="{{$post->id}}" onclick="bookmarkPost(this);">
                                        <i class="fas fa-star"></i>
                                    </a>
                                @else
                                    <a href="" title="Bookmark this post" bookmark-post-id="{{$post->id}}" onclick="bookmarkPost(this);">
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
                            <p class="alert-info">For Sale</p>
                        @elseif($post->type === 'rent')
                            <p class="alert-info">For Rent</p>
                        @endif
                        @if($post->property_type === 'apartment')
                            <p>{{ $post->floor }}. floor</p>
                        @elseif($post->property_type === 'house')
                            @if($post->floor === 1)
                                <p>1 floor</p>
                            @else
                                <p>{{ $post->floor }} floors</p>
                            @endif
                        @endif
                        <p>{{ $post->area }} square meters</p>
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
                            <p>${{ number_format($post->price) }} / month</p>
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
