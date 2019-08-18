@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Dashboard</div>

            <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <a class="btn btn-warning" href="/users/{{auth()->user()->id}}/edit">Edit</a>

                @if(Auth::user()->role === 'admin')
                    <p><a href="/users" class="btn btn-link">Users</a></p>
                @endif

                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'mod')
                    <p><a href="/reports" class="btn btn-link">Reports</a></p>
                @endif

                <p><a href="/bookmarks" class="btn btn-link">Bookmarks</a></p>

                @if(auth()->user() && (auth()->user()->role === 'mod' || auth()->user()->role === 'admin'))
                    <p><a href="/posts" class="btn btn-link">Posts</a></p>
                @endif

                <p><a href="/posts/create" class="btn btn-link">Create Post</a></p>

                <h3>Posts by you</h3>
                @if(count($posts) > 0)
                    <table class="table table-striped">
                        <tr>
                            <th>Post</th>
                            <th></th>
                            <th></th>
                        </tr>
                        @foreach($posts as $post)
                            <tr>
                                <td>
                                    <a class="post-thumb" href="/posts/{{$post->id}}/{{$post->slug}}">
                                        <img src="/storage/images/cover_images/thumbnails/{{$post->thumbnail}}">
                                    </a>
                                </td>
                                <td>
                                   <a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>
                                </td>
                                <td>
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
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{$posts->links()}}
                @else
                    <p>You have no posts.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
