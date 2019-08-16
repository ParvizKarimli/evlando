@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-md-offset-0">
        <div class="panel panel-default">
            <div class="panel-heading">Reports</div>

            <div class="panel-body">

                <p><a href="/dashboard" class="btn btn-link">Dashboard</a></p>

                <div class="form-group">
                    <label for="type">Type:</label>
                    <select id="site-type" name="type" site="reports">
                        <option value="all">All</option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                </div>

                <h3>Reports</h3>
                @if(count($reports) > 0)
                    <table class="table">
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Reporter User</th>
                            <th>Reported User/Post</th>
                            <th>Category</th>
                            <th>Message</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th></th>
                        </tr>
                        @foreach($reports as $report)
                            <tr @if($report->seen === 0) class="alert alert-info" @endif>
                                <td>
                                    @if($report->resolved === 1)
                                        <h4 class="alert-success" title="Resolved">&#10004;</h4>
                                    @endif
                                </td>
                                <td>{{$report->id}}</td>
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
                                    <a href="/reports/{{$report->id}}">
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
</div>
@endsection
