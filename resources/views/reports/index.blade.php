@extends('layouts.adminpanel.app')

@section('title', __('reports.reports'))

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{ __('reports.reports') }}</div>

    <div class="panel-body">
        <div class="row">
            {!! Form::open(['action' => 'ReportsController@get', 'method' => 'GET']) !!}
                <div class="form-group col-md-2">
                    <label for="types">{{ __('reports.types') }}</label>
                    <div class="checkbox">
                        <label>
                            {{ Form::checkbox('types[]', 'users') }} {{ __('users.users') }}
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('types[]', 'posts') !!} {{ __('posts.posts') }}
                        </label>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label for="seen">{{ __('reports.seen') }}</label>
                    <div class="checkbox">
                        <label>
                            {{ Form::checkbox('seen[]', '0') }} {{ __('reports.seen_1') }}
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('seen[]', '1') !!} {{ __('reports.unseen_0') }}
                        </label>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label for="resolved">{{ __('reports.resolved') }}</label>
                    <div class="checkbox">
                        <label>
                            {{ Form::checkbox('resolved[]', '0') }} {{ __('reports.resolved_1') }}
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('resolved[]', '1') !!} {{ __('reports.unresolved_0') }}
                        </label>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label for="categories">{{ __('reports.categories') }}</label>
                    <div class="checkbox">
                        <label>
                            {{ Form::checkbox('categories[]', '1') }} {{ __('reports.spam') }}
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('categories[]', '2') !!} {{ __('reports.nudity') }}
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            {{ Form::checkbox('categories[]', '3') }} {{ __('reports.hate_speech') }}
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('categories[]', '4') !!} {{ __('reports.other') }}
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    {{Form::submit(__('reports.get_reports'), ['class' => 'btn btn-default'])}}
                </div>
            {!! Form::close() !!}
        </div>

        <div class="row">
            @if(count($reports) > 0)
                <table class="table">
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>{{ __('reports.reporter_user') }}</th>
                        <th>{{ __('reports.reported_user_post') }}</th>
                        <th>{{ __('reports.category') }}</th>
                        <th>{{ __('reports.message') }}</th>
                        <th>{{ __('reports.reported_at') }}</th>
                        <th>{{ __('reports.updated_at') }}</th>
                        <th></th>
                    </tr>
                    @foreach($reports as $report)
                        <tr @if($report->seen === 0) class="alert alert-info" @endif>
                            <td>
                                @if($report->resolved === 1)
                                    <span class="resolved-report-sign" title="{{ __('reports.report_resolved') }}">
                                        &#10004;
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="/reports/{{$report->id}}" title="{{ __('reports.click_to_see_the_full_report') }}">
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
                                <a href="/reports/{{$report->id}}" title="{{ __('reports.click_to_see_the_full_report') }}">
                                    {{str_limit($report->message, $limit = 15, $end = '...')}}
                                </a>
                            </td>
                            <td>{{$report->created_at}}</td>
                            <td>{{$report->updated_at}}</td>
                            <td>
                                <a class="btn btn-danger pull-right" href="" onclick="
                                    event.preventDefault();
                                    if(confirm('{{ __("reports.delete_question") }}')) {
                                        document.getElementById('report-delete-form-{{$report->id}}').submit();
                                    }
                                ">
                                    {{ __('reports.delete') }}
                                </a>
                                {!! Form::open(
                                    [
                                        'action' =>
                                        [
                                            'ReportsController@destroy',
                                            $report->id
                                        ],
                                        'method' => 'DELETE',
                                        'id' => 'report-delete-form-' . $report->id
                                    ]
                                ) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{$reports->links()}}
            @else
                <p>{{ __('reports.no_reports_found') }}</p>
            @endif
        </div>
    </div>
</div>
@endsection
