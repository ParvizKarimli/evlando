@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
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
                    <table class="table table-striped">
                        <tr>
                            <th>ID</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th></th>
                        </tr>
                        @foreach($reports as $report)
                            <tr>
                                <td>{{$report->id}}</td>
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
