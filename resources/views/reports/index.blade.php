@extends('layouts.adminpanel.app')

@section('title', 'Reports')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">Reports</div>

    <div class="panel-body">
        <div class="row">
            {!! Form::open(['action' => 'ReportsController@get', 'method' => 'GET']) !!}
                <div class="form-group col-md-2">
                    <label for="types">Types</label>
                    <div class="checkbox">
                        <label>
                            {{ Form::checkbox('types[]', 'users') }} Users
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('types[]', 'posts') !!} Posts
                        </label>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label for="seen">Seen</label>
                    <div class="checkbox">
                        <label>
                            {{ Form::checkbox('seen[]', '0') }} Unseen
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('seen[]', '1') !!} Seen
                        </label>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label for="resolved">Resolved</label>
                    <div class="checkbox">
                        <label>
                            {{ Form::checkbox('resolved[]', '0') }} Unresolved
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('resolved[]', '1') !!} Resolved
                        </label>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label for="categories">Categories</label>
                    <div class="checkbox">
                        <label>
                            {{ Form::checkbox('categories[]', '1') }} Spam
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('categories[]', '2') !!} Nudity
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            {{ Form::checkbox('categories[]', '3') }} Hate speech
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('categories[]', '4') !!} Other
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    {{Form::submit('Get Reports', ['class' => 'btn btn-default'])}}
                </div>
            {!! Form::close() !!}
        </div>

        <div class="row">
            @if(count($reports) > 0)
                <table class="table">
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Reporter User</th>
                        <th>Reported User/Post</th>
                        <th>Category</th>
                        <th>Message</th>
                        <th>Reported at</th>
                        <th>Updated at</th>
                        <th></th>
                    </tr>
                    @foreach($reports as $report)
                        <tr @if($report->seen === 0) class="alert alert-info" @endif>
                            <td>
                                @if($report->resolved === 1)
                                    <span class="resolved-report-sign" title="Resolved">&#10004;</span>
                                @endif
                            </td>
                            <td>
                                <a href="/reports/{{$report->id}}" title="Click to see the full report">
                                    {{$report->id}}
                                </a>
                            </td>
                            <td>
                                <a href="/users/{{$report->reporter_user_id}}">
                                    {{$report->reporter_user_id}}
                                </a>
                            </td>
                            @if($report->reported_user_id)
                                <td>
                                    <a href="/users/{{$report->reported_user_id}}">
                                        {{$report->user->name}}
                                    </a>
                                </td>
                            @else
                                <td>
                                    <a href="/posts/{{$report->post_id}}/{{$report->post->slug}}">
                                        <img src="/storage/images/cover_images/thumbnails/{{$report->post->thumbnail}}">
                                    </a>
                                </td>
                            @endif
                            @if($report->category === 1)
                                <td>Spam</td>
                            @elseif($report->category === 2)
                                <td>Nudity</td>
                            @elseif($report->category === 3)
                                <td>Hate speech</td>
                            @elseif($report->category === 4)
                                <td>Other</td>
                            @endif
                            <td>
                                <a href="/reports/{{$report->id}}" title="Click to see the full report">
                                    {{str_limit($report->message, $limit = 15, $end = '...')}}
                                </a>
                            </td>
                            <td>{{$report->created_at}}</td>
                            <td>{{$report->updated_at}}</td>
                            <td>
                                <a class="btn btn-danger pull-right" href="" onclick="
                                    event.preventDefault();
                                    if(confirm('Delete report?')) {
                                        document.getElementById('report-delete-form-{{$report->id}}').submit();
                                    }
                                ">
                                    Delete
                                </a>
                                {!! Form::open(['action' => ['ReportsController@destroy', $report->id], 'method' => 'DELETE', 'id' => 'report-delete-form-' . $report->id]) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{$reports->links()}}
            @else
                <p>No reports found.</p>
            @endif
        </div>
    </div>
</div>
@endsection
