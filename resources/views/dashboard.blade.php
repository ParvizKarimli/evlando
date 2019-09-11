@extends('layouts.adminpanel.app')

@section('title', 'Dashboard')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <p>{{ __('navbar.dashboard') }}</p>
    </div>

    <div class="panel-body">
        <p>
            <a href="/posts/create" class="btn btn-link">
                <i class="fa fa-plus"> {{ __('posts.create_post') }}</i>
            </a>
        </p>

        <h3>{{ __('posts.posts_by_you') }}</h3>
        @if(count($posts) > 0)
            <table class="table table-striped">
                <tr>
                    <th>{{ __('posts.post') }}</th>
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
                           <a href="/posts/{{$post->id}}/edit" class="btn btn-default">{{ __('posts.edit') }}</a>
                        </td>
                        <td>
                            <a class="btn btn-danger pull-right" href="" onclick="
                                event.preventDefault();
                                if(confirm('{{ __("posts.delete_question") }}')) {
                                    document.getElementById('post-{{$post->id}}').submit();
                                }
                            ">
                                {{ __('posts.delete') }}
                            </a>
                            {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'DELETE', 'id' => 'post-' . $post->id]) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </table>
            {{$posts->links()}}
        @else
            <p>{{ __('posts.you_have_no_posts') }}</p>
        @endif
    </div>
</div>
@endsection
