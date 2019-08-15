@extends('layouts.app')

@section('content')
<div class="col-md-4 col-sm-4">
    <!-- Empty space -->
</div>
<div class="col-md-8 col-sm-8">
    <h1>
        Newest Posts
    </h1>
</div>
<div class="col-md-4 col-sm-4">
    <h1>Search</h1>
    <div class="well">
        {!! Form::open(['action' => 'PostsController@search', 'method' => 'GET']) !!}
        <div class="form-group">
            {!! Form::label('location-input', 'Location') !!}
            {!! Form::text('location', '', ['id' => 'location-input', 'class' => 'form-control', 'placeholder' => 'New York', 'autocomplete' => 'off']) !!}
            {!! Form::hidden('location_id', '', ['id' => 'location_id']) !!}
        </div>
        <div id="location-suggestions-container"></div>
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
            <label for="area">Area (ft<sup>2</sup>)</label>
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
            <label for="price">Price</label>
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
            {{Form::submit('Search', ['class' => 'btn btn-default'])}}
        </div>
        {!! Form::close() !!}
    </div>
</div>
<div class="col-md-8 col-sm-8">
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

                                <!-- Trigger the modal with a button -->
                                <a class="pull-right" href="" title="Report this post" data-toggle="modal" data-target="#reportModal">
                                    <i class="fas fa-flag"></i>
                                </a>

                                <!-- Modal -->
                                <div id="reportModal" class="modal fade" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Modal Header</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Some text in the modal.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @elseif(auth()->guest())
                                <a href="{{route('login')}}" title="Bookmark this post">
                                    <i class="far fa-star"></i>
                                </a>

                                <a class="pull-right" href="{{route('login')}}" title="Report this post">
                                    <i class="fas fa-flag"></i>
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
                            Created at {{$post->created_at}} by <a href="/users/{{$post->user->id}}">{{$post->user->name}}</a>
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
@endsection
