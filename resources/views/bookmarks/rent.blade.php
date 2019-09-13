@extends('layouts.adminpanel.app')

@section('title', __('bookmarks.bookmarks') . ' (' . __('posts.for_rent') . ')')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{ __('bookmarks.bookmarks') . ' (' . __('posts.for_rent') . ')' }}</div>

    <div class="panel-body">
        @if(count($bookmarks) > 0)
            <table class="table table-striped">
                <tr>
                    <th>{{ __('posts.post') }}</th>
                    <th></th>
                </tr>
                @foreach($bookmarks as $bookmark)
                    <tr>
                        <td>
                            <a class="post-thumb" href="/posts/{{$bookmark->post_id}}/{{$bookmark->post->slug}}">
                                <img src="/storage/images/cover_images/thumbnails/{{$bookmark->post->thumbnail}}">
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-danger pull-right" href="" onclick="
                                event.preventDefault();
                                if(confirm('{{ __("bookmarks.delete_question") }}')) {
                                    document.getElementById('bookmark-delete-form-{{$bookmark->id}}').submit();
                                }
                            ">
                                {{ __('bookmarks.delete') }}
                            </a>
                            {!! Form::open(['action' => ['BookmarksController@destroy', $bookmark->id], 'method' => 'DELETE', 'id' => 'bookmark-delete-form-' . $bookmark->id]) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </table>
            {{$bookmarks->links()}}
        @else
            <p>{{ __('bookmarks.you_have_no_bookmarks_for_rent') }}</p>
        @endif
    </div>
</div>
@endsection
