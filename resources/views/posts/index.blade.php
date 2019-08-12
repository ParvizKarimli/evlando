@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Posts</div>

            <div class="panel-body">

                <p><a href="/dashboard" class="btn btn-link">Dashboard</a></p>

                <h3>Posts</h3>
                @if(count($posts) > 0)
                    <table class="table table-striped">
                        <tr>
                            <th>Post</th>
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
                                    <a class="btn btn-danger pull-right" href="" onclick="
                                        event.preventDefault();
                                        if(confirm('Delete post?')) {
                                            document.getElementById('post-delete-form-{{$post->id}}').submit();
                                        }
                                    ">
                                        Delete
                                    </a>
                                    {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'DELETE', 'id' => 'post-delete-form-' . $post->id]) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{$posts->links()}}
                @else
                    <p>No posts found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
