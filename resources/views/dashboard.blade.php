@extends('layouts.adminpanel.app')

@section('title', 'Dashboard')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <p>Dashboard</p>
    </div>

    <div class="panel-body">
        <p>
            <a href="/posts/create" class="btn btn-link">
                <i class="fa fa-plus"> Create Post</i>
            </a>
        </p>

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
@endsection
