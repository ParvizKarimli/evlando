@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>
                    {{$user->name}}

                    @if($user->id !== auth()->user()->id)
                        <!-- Trigger the modal with a button -->
                        <a href="" title="Report this user" data-toggle="modal" data-target="#reportModal">
                            &#9873
                        </a>
                    @endif
                </h1>

                <!-- Modal -->
                <div id="reportModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Report User</h4>
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
                                    {!! Form::hidden('reported_type', 'user') !!}
                                    {!! Form::hidden('user_id', $user->id) !!}
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
            </div>

            <div class="panel-body">
                @if($user->banned === 1)
                    <div>
                        <img src="/storage/images/default/suspended-1.jpg">
                    </div>
                @endif

                <h3>Posts by {{$user->name}}</h3>
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
                                <div>
                                    <h1>
                                        @if(in_array($post->id, $bookmarked_posts_ids))
                                            <a href="" title="Remove this post from bookmarks" bookmark-post-id="{{$post->id}}"
                                               class="post-to-bookmark">
                                                &#9733
                                            </a>
                                        @else
                                            <a href="" title="Bookmark this post" bookmark-post-id="{{$post->id}}"
                                               class="post-to-bookmark">
                                                &#9734
                                            </a>
                                        @endif

                                        @if($post->user_id !== auth()->user()->id)
                                            <!-- Trigger the modal with a button -->
                                            <a class="pull-right" href="" title="Report this post" data-toggle="modal" data-target="#reportModal-{{$post->id}}">
                                                &#9873
                                            </a>
                                        @endif
                                    </h1>

                                    <!-- Modal -->
                                    <div id="reportModal-{{$post->id}}" class="modal fade" role="dialog">
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
                                </div>
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
