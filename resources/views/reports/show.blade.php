@extends('layouts.app')

@section('title', 'Report - ' . $report->id)

@section('content')
<div class="well">
    <div class="row">
        <h1><a href="/reports">Reports</a></h1>
        <hr>
        <p>
            <b>Report ID:</b><br>
            {{$report->id}}
            @if($report->resolved === 1)
                <span class="resolved-report-sign" title="Resolved">&#10004;</span>
            @endif
        </p>
        @if($report->reported_user_id !== NULL)
            <p>
                <b>Reported User:</b><br>
                <a href="/users/{{$report->reported_user_id}}">{{$report->user->name}}</a>
            </p>
        @else
            <p>
                <b>Reported Post:</b><br>
                <a href="/posts/{{$report->post_id}}">
                    <img src="/storage/images/cover_images/thumbnails/{{$report->post->thumbnail}}">
                </a>
            </p>
        @endif
        <p><b>Category:</b><br>
            @if($report->category === 1)
                Spam
            @elseif($report->category === 2)
                Nudity
            @elseif($report->category === 3)
                Hate speech
            @elseif($report->category === 4)
                Other
            @endif
        </p>
        <p>
            <b>Message:</b><br>
            <span>{{ $report->message }}</span>
        </p>
        <p>
            <small>
                Reported at {{$report->created_at}} by
                <a href="/users/{{$report->reporter_user_id}}">
                    {{$report->reporter_user_id}}
                </a>
            </small>
        </p>
        <p>
            <small>
                Updated at {{$report->updated_at}}
            </small>
        </p>
    </div>
</div>

@if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'mod'))
    <hr>
    @if($report->resolved === 0)
        <a class="btn btn-success" href="" onclick="
            event.preventDefault();
            if(confirm('Mark report as resolved?')) {
                document.getElementById('report-resolve-form-{{$report->id}}').submit();
            }
        ">
            Mark as resolved
        </a>
    @else
        <a class="btn btn-info" href="" onclick="
            event.preventDefault();
            if(confirm('Mark report as unresolved?')) {
                document.getElementById('report-resolve-form-{{$report->id}}').submit();
            }
        ">
            Mark as unresolved
        </a>
    @endif
    {!! Form::open(['action' => ['ReportsController@update', $report->id], 'method' => 'PUT', 'id' => 'report-resolve-form-' . $report->id]) !!}
    {!! Form::close() !!}

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
@endif
@endsection
