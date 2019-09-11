@extends('layouts.adminpanel.app')

@section('title', __('posts.posts'))

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{ __('posts.posts') }}</div>

    <div class="panel-body">
        @if(count($posts) > 0)
            <table class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>{{ __('posts.thumb') }}</th>
                    <th>{{ __('posts.created_at') }}</th>
                    <th>{{ __('posts.updated_at') }}</th>
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
                                    if(confirm('{{ __("posts.suspend_question") }}')) {
                                        document.getElementById('post-suspend-form-{{$post->id}}').submit();
                                    }
                                ">
                                    {{ __('posts.suspend') }}
                                </a>
                            @elseif($post->suspended === 1)
                                <a class="btn btn-warning pull-right" href="" onclick="
                                    event.preventDefault();
                                    if(confirm('{{ __("posts.resume_question") }}')) {
                                        document.getElementById('post-suspend-form-{{$post->id}}').submit();
                                    }
                                ">
                                    {{ __('posts.resume') }}
                                </a>
                            @endif
                            {!! Form::open(['action' => ['PostsController@suspend'], 'method' => 'POST', 'id' => 'post-suspend-form-' . $post->id]) !!}
                                {!! Form::hidden('id', $post->id) !!}
                            {!! Form::close() !!}
                        </td>
                        <td>
                            <a class="btn btn-danger pull-right" href="" onclick="
                                event.preventDefault();
                                if(confirm('{{ __("posts.delete_question") }}')) {
                                    document.getElementById('post-delete-form-{{$post->id}}').submit();
                                }
                            ">
                                {{ __('posts.delete') }}
                            </a>
                            {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'DELETE', 'id' => 'post-delete-form-' . $post->id]) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </table>
            {{$posts->links()}}
        @else
            <p>{{ __('posts.no_posts_found') }}</p>
        @endif
    </div>
</div>
@endsection
