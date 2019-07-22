@extends('layouts.app')

@section('content')
<div class="well">
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <img style="width:100%" src="/storage/images/cover_images/{{$post->cover_image}}">
        </div>
        <div class="col-md-6 col-sm-6">
            <h1>
                @if(auth()->user())
                    @if($bookmarked === false)
                        <a href="" title="Bookmark this post" bookmark-post-id="{{$post->id}}" onclick="bookmarkPost(this);">
                            <i class="far fa-star"></i>
                        </a>
                    @elseif($bookmarked === true)
                        <a href="" title="Remove this post from bookmarks" bookmark-post-id="{{$post->id}}" onclick="bookmarkPost(this);">
                            <i class="fas fa-star"></i>
                        </a>
                    @endif
                @elseif(auth()->guest())
                    <a href="{{route('login')}}" title="Bookmark this post">
                        <i class="far fa-star"></i>
                    </a>
                @endif
            </h1>
            @if($post->type === 'sale')
                <p class="alert-info">For Sale</p>
            @elseif($post->type === 'rent')
                <p class="alert-info">For Rent</p>
            @endif
            @if($post->property_type === 'apartment')
                <p>{{ $post->floor }}. floor</p>
            @elseif($post->property_type === 'house')
                @if($post->floor === 1)
                    <p>{{ $post->floor }} floor</p>
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
                <p>${{ number_format($post->price) }}/month</p>
            @endif
            <p>
                <i class="fas fa-map-marker-alt"></i>
                {{ $post->location->city }}, {{ $post->location->province }}, {{ $post->location->country }}
            </p>
            <small>Created at {{$post->created_at}} by {{$post->user->name}}</small>
            <div>{!!$post->body!!}</div>
            <span>
                <i class="fas fa-eye"></i>
                {{ Counter::showAndCount('/posts/{$post->id}', $post->id) }}
            </span>
        </div>
    </div>
</div>

@if(count($images) > 0)
    <div class="well">
        <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:600px;height:500px;overflow:hidden;visibility:hidden;">
            <!-- Loading Screen -->
            <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
                <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="/storage/images/default/spin.svg" />
            </div>
            <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:600px;height:500px;overflow:hidden;">
                @foreach($images as $image)
                    <div>
                        <img data-u="image" src="/storage/images/{{$image->filename}}" />
                    </div>
                @endforeach
            </div>
            <!-- Bullet Navigator -->
            <div data-u="navigator" class="jssorb072" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
                <div data-u="prototype" class="i" style="width:24px;height:24px;font-size:12px;line-height:24px;">
                    <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;z-index:-1;">
                        <circle class="b" cx="8000" cy="8000" r="6666.7"></circle>
                    </svg>
                    <div data-u="numbertemplate" class="n"></div>
                </div>
            </div>
            <!-- Arrow Navigator -->
            <div data-u="arrowleft" class="jssora073" style="width:40px;height:50px;top:0px;left:30px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
                <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                    <path class="a" d="M4037.7,8357.3l5891.8,5891.8c100.6,100.6,219.7,150.9,357.3,150.9s256.7-50.3,357.3-150.9 l1318.1-1318.1c100.6-100.6,150.9-219.7,150.9-357.3c0-137.6-50.3-256.7-150.9-357.3L7745.9,8000l4216.4-4216.4 c100.6-100.6,150.9-219.7,150.9-357.3c0-137.6-50.3-256.7-150.9-357.3l-1318.1-1318.1c-100.6-100.6-219.7-150.9-357.3-150.9 s-256.7,50.3-357.3,150.9L4037.7,7642.7c-100.6,100.6-150.9,219.7-150.9,357.3C3886.8,8137.6,3937.1,8256.7,4037.7,8357.3 L4037.7,8357.3z"></path>
                </svg>
            </div>
            <div data-u="arrowright" class="jssora073" style="width:40px;height:50px;top:0px;right:30px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
                <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                    <path class="a" d="M11962.3,8357.3l-5891.8,5891.8c-100.6,100.6-219.7,150.9-357.3,150.9s-256.7-50.3-357.3-150.9 L4037.7,12931c-100.6-100.6-150.9-219.7-150.9-357.3c0-137.6,50.3-256.7,150.9-357.3L8254.1,8000L4037.7,3783.6 c-100.6-100.6-150.9-219.7-150.9-357.3c0-137.6,50.3-256.7,150.9-357.3l1318.1-1318.1c100.6-100.6,219.7-150.9,357.3-150.9 s256.7,50.3,357.3,150.9l5891.8,5891.8c100.6,100.6,150.9,219.7,150.9,357.3C12113.2,8137.6,12062.9,8256.7,11962.3,8357.3 L11962.3,8357.3z"></path>
                </svg>
            </div>
        </div>
    </div>
@endif

@if(!Auth::guest() && Auth::user()->id === $post->user_id)
    <hr>
    <a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>

    <a class="btn btn-danger pull-right" href="" onclick="
        event.preventDefault();
        if(confirm('Delete post?')) {
            document.getElementById('post-{{$post->id}}').submit();
        }
    ">
        Delete
    </a>
    {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'DELETE', 'id' => 'post-' . $post->id]) !!}
    {!! Form::close() !!}
@endif
@endsection

@section('jssor')
<script type="text/javascript">jssor_1_slider_init();</script>
@endsection
