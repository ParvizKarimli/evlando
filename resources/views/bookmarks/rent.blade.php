@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Bookmarks</div>

            <div class="panel-body">

                <p><a href="/dashboard" class="btn btn-primary">Dashboard</a></p>

                <h3>Your Bookmarks</h3>
                <div class="form-group">
                    <label for="type">Type:</label>
                    <select name="type" site="bookmarks" onchange="typeChange(this)">
                        <option value="all">All</option>
                        <option value="sale">For Sale</option>
                        <option value="rent" selected>For Rent</option>
                    </select>
                </div>
                @if(count($bookmarks) > 0)
                    <table class="table table-striped">
                        <tr>
                            <th>Post Title & Link</th>
                            <th></th>
                        </tr>
                        @foreach($bookmarks as $bookmark)
                            <tr>
                                <td>
                                    <a href="/posts/{{$bookmark->post_id}}">
                                        {{$bookmark->post->title}}
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
                    <p>You have no bookmarks for properties for rent.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
