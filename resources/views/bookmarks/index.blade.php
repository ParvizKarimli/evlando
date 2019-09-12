@extends('layouts.adminpanel.app')

@section('title', 'Bookmarks')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">Bookmarks</div>

    <div class="panel-body">
        @if(count($bookmarks) > 0)
            <table class="table table-striped">
                <tr>
                    <th>Post</th>
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
                                if(confirm('Delete bookmark?')) {
                                    document.getElementById('bookmark-delete-form-{{$bookmark->id}}').submit();
                                }
                            ">
                                Delete
                            </a>
                            {!! Form::open(['action' => ['BookmarksController@destroy', $bookmark->id], 'method' => 'DELETE', 'id' => 'bookmark-delete-form-' . $bookmark->id]) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </table>
            {{$bookmarks->links()}}
        @else
            <p>You have no bookmarks.</p>
        @endif
    </div>
</div>
@endsection
