@extends('layouts.app')

@section('title', $post->slug)

@section('content')
<div class="well">
    <div class="row">
        <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:600px;height:500px;overflow:hidden;visibility:hidden;">
            <!-- Loading Screen -->
            <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
                <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="/storage/images/default/spin.svg" />
            </div>
            <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:600px;height:500px;overflow:hidden;">
                <div title="Click to open this image in new tab">
                    <a href="/storage/images/cover_images/{{$post->cover_image}}" target="_blank">
                        <img style="width:100%" src="/storage/images/cover_images/{{$post->cover_image}}">
                    </a>
                </div>
                @foreach($images as $image)
                    <div title="Click to open this image in new tab">
                        <a href="/storage/images/{{$image->filename}}" target="_blank">
                            <img data-u="image" src="/storage/images/{{$image->filename}}" />
                        </a>
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
        <div class="text-center">
            @if($post->suspended === 1)
                <div>
                    <img src="/storage/images/default/suspended-1.jpg">
                </div>
            @endif
            <div>
                <h1>
                    @if(auth()->user())
                        @if($bookmarked === false)
                            <a href="" title="{{ __('bookmarks.bookmark') }}" bookmark-post-id="{{$post->id}}"
                            class="post-to-bookmark no-txt-decor">
                                &#9734
                            </a>
                        @elseif($bookmarked === true)
                            <a href="" title="{{ __('bookmarks.remove') }}" bookmark-post-id="{{$post->id}}"
                            class="post-to-bookmark no-txt-decor">
                                &#9733
                            </a>
                        @endif

                        @if($post->user_id !== auth()->user()->id)
                            <!-- Trigger the modal with a button -->
                            <a class="pull-right no-txt-decor" href="" title="Report this post" data-toggle="modal" data-target="#reportModal">
                                &#9872
                            </a>
                </h1>
                            <!-- Modal -->
                            <div id="reportModal" class="modal fade text-left" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Report Post</h4>
                                        </div>
                                        <div class="modal-body">
                                            {!! Form::open(['action' => 'ReportsController@store', 'method' => 'POST']) !!}
                                                <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
                                                    <label for="category">Category (required)</label>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="category" value="1" required> Spam
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="category" value="2" required> Nudity
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="category" value="3" required> Hate speech
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="category" value="4" required> Other
                                                        </label>
                                                    </div>
                                                    @if($errors->has('category'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('category') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                                                    {{Form::label('message', 'Message (optional)')}}
                                                    {{Form::textarea('message', '', ['rows' => 4, 'class' => 'form-control', 'placeholder' => 'Message'])}}
                                                    @if($errors->has('message'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('message') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                {!! Form::hidden('reported_type', 'post') !!}
                                                {!! Form::hidden('post_id', $post->id) !!}
                                                {!! Form::hidden('post_owner_id', $post->user_id) !!}
                                                <div class="form-group">
                                                    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                                                </div>
                                            {!! Form::close() !!}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endif
                    @elseif(auth()->guest())
                        <a class="no-txt-decor" href="{{route('login')}}" title="{{ __('bookmarks.bookmark') }}">
                            &#9734
                        </a>

                        <a class="no-txt-decor" href="{{route('login')}}" title="{{ __('reports.report_post') }}">
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
            <div>
                <span title="{{ __('posts.seen_count') }}">
                    <i class="fas fa-eye"></i>
                    {{ Counter::showAndCount('/posts/{$post->id}', $post->id) }}
                </span>
            </div>
        </div>
    </div>
</div>

@if(auth()->user() && (auth()->user()->role === 'mod' || auth()->user()->role === 'admin'))
    @if($post->suspended === 0)
        <a class="btn btn-warning" href="" onclick="
            event.preventDefault();
            if(confirm('Suspend post?')) {
                document.getElementById('post-suspend-form-{{$post->id}}').submit();
            }
        ">
            {{ __('posts.suspend') }}
        </a>
    @endif
    {!! Form::open(['action' => ['PostsController@suspend'], 'method' => 'POST', 'id' => 'post-suspend-form-' . $post->id]) !!}
        {!! Form::hidden('id', $post->id) !!}
    {!! Form::close() !!}
@endif

@if(!Auth::guest() && Auth::user()->id === $post->user_id)
    <hr>
    <a href="/posts/{{$post->id}}/edit" class="btn btn-default">{{ __('posts.edit') }}</a>

    <a class="btn btn-danger pull-right" href="" onclick="
        event.preventDefault();
        if(confirm('Delete post?')) {
            document.getElementById('post-{{$post->id}}').submit();
        }
    ">
        {{ __('posts.delete') }}
    </a>
    {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'DELETE', 'id' => 'post-' . $post->id]) !!}
    {!! Form::close() !!}
@endif
@endsection

@section('jssor')
<script type="text/javascript">jssor_1_slider_init();</script>
@endsection
