@extends('layouts.app')

@section('title', 'Posts')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Posts</div>

            <div class="panel-body">

                <p><a href="/dashboard" class="btn btn-link">Dashboard</a></p>

                <div class="form-group">
                    <label for="type">Type:</label>
                    <select id="site-type" name="type" site="posts">
                        <option value="all">All</option>
                        <option value="suspended">Suspended</option>
                        <option value="active">Active</option>
                    </select>
                </div>

                <h3>Posts</h3>
                @if(count($posts) > 0)
                    <table class="table table-striped">
                        <tr>
                            <th>ID</th>
                            <th>Thumb</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th></th>
                        </tr>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{$post->id}}</td>
                                <td>
                                    <a class="post-thumb" href="/posts/{{$post->id}}/{{$post->slug}}">
                                        <img src="/storage/images/cover_images/thumbnails/{{$post->thumbnail}}">
                                    </a>
                                </td>
                                <td>{{$post->created_at}}</td>
                                <td>{{$post->updated_at}}</td>
                                <td>
                                    @if($post->suspended === 0)
                                        <a class="btn btn-warning pull-right" href="" onclick="
                                            event.preventDefault();
                                            if(confirm('Suspend post?')) {
                                                document.getElementById('post-suspend-form-{{$post->id}}').submit();
                                            }
                                        ">
                                            Suspend
                                        </a>
                                    @elseif($post->suspended === 1)
                                        <a class="btn btn-warning pull-right" href="" onclick="
                                            event.preventDefault();
                                            if(confirm('Resume post?')) {
                                                document.getElementById('post-suspend-form-{{$post->id}}').submit();
                                            }
                                        ">
                                            Resume
                                        </a>
                                    @endif
                                    {!! Form::open(['action' => ['PostsController@suspend'], 'method' => 'POST', 'id' => 'post-suspend-form-' . $post->id]) !!}
                                        {!! Form::hidden('id', $post->id) !!}
                                    {!! Form::close() !!}
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
