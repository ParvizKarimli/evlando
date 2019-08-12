@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Your Bookmarks</div>

            <div class="panel-body">

                <p><a href="/dashboard" class="btn btn-link">Dashboard</a></p>

                <div class="form-group">
                    <label for="type">Type:</label>
                    <select id="site-type" name="type" site="bookmarks">
                        <option value="all">All</option>
                        <option value="sale">For Sale</option>
                        <option value="rent">For Rent</option>
                    </select>
                </div>
                <h3>Your Bookmarks</h3>
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
    </div>
</div>
@endsection
