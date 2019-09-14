@extends('layouts.adminpanel.app')

@section('title', __('reports.report') . ' - ' . $report->id)

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <a href="/reports">{{ __('reports.reports') }}</a>
    </div>

    <div class="panel-body">
        <p>
            <b>{{ __('reports.report') }} ID:</b><br>
            {{$report->id}}
            @if($report->resolved === 1)
                <span class="resolved-report-sign" title="{{ __('reports.report_resolved') }}">&#10004;</span>
            @endif
        </p>
        @if($report->reported_user_id !== NULL)
            <p>
                <b>{{ __('reports.reported_user') }}:</b><br>
                <a href="/users/{{$report->reported_user_id}}">{{$report->user->name}}</a>
            </p>
        @else
            <p>
                <b>{{ __('reports.reported_post') }}:</b><br>
                <a href="/posts/{{$report->post_id}}">
                    <img src="/storage/images/cover_images/thumbnails/{{$report->post->thumbnail}}">
                </a>
            </p>
        @endif
        <p><b>{{ __('reports.category') }}:</b><br>
            @if($report->category === 1)
                {{ __('reports.spam') }}
            @elseif($report->category === 2)
                {{ __('reports.nudity') }}
            @elseif($report->category === 3)
                {{ __('reports.hate_speech') }}
            @elseif($report->category === 4)
                {{ __('reports.other') }}
            @endif
        </p>
        <p>
            <b>{{ __('reports.message') }}:</b><br>
            <span>{{ $report->message }}</span>
        </p>
        <p>
            <small>
                {!!
                    __(
                        'reports.reported_at_by',
                        [
                            'at' => $report->created_at,
                            'by' => '<a href="/users/' . $report->reporter_user_id . '">' . $report->reporter_user_id . '</a>'
                            // or
                            // 'by' => link_to('/users/' . $report->reporter_user_id, $report->reporter_user_id)
                        ]
                    )
                !!}
            </small>
        </p>
        <p>
            <small>
                {{ __('reports.updated_at') }} {{$report->updated_at}}
            </small>
        </p>


        @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'mod'))
            <hr>
            @if($report->resolved === 0)
                <a class="btn btn-success" href="" onclick="
                    event.preventDefault();
                    if(confirm('{{ __("reports.mark_as_resolved_question") }}')) {
                        document.getElementById('report-resolve-form-{{$report->id}}').submit();
                    }
                ">
                    {{ __('reports.mark_as_resolved') }}
                </a>
            @else
                <a class="btn btn-info" href="" onclick="
                    event.preventDefault();
                    if(confirm('{{ __("reports.mark_as_unresolved_question") }}')) {
                        document.getElementById('report-resolve-form-{{$report->id}}').submit();
                    }
                ">
                    {{ __('reports.mark_as_unresolved') }}
                </a>
            @endif
            {!! Form::open(['action' => ['ReportsController@update', $report->id], 'method' => 'PUT', 'id' => 'report-resolve-form-' . $report->id]) !!}
            {!! Form::close() !!}

            <a class="btn btn-danger pull-right" href="" onclick="
                event.preventDefault();
                if(confirm('{{ __("reports.delete_question") }}')) {
                    document.getElementById('report-delete-form-{{$report->id}}').submit();
                }
            ">
                {{ __('reports.delete') }}
            </a>
            {!! Form::open(['action' => ['ReportsController@destroy', $report->id], 'method' => 'DELETE', 'id' => 'report-delete-form-' . $report->id]) !!}
            {!! Form::close() !!}
        @endif
    </div>
@endsection
