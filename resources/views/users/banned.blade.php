@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Users</div>

            <div class="panel-body">

                <p><a href="/dashboard" class="btn btn-link">Dashboard</a></p>

                <div class="form-group">
                    <label for="type">Type:</label>
                    <select id="site-type" name="type" site="users">
                        <option value="all">All</option>
                        <option value="banned" selected>Banned</option>
                        <option value="active">Active</option>
                    </select>
                </div>

                <h3>Banned Users</h3>
                @if(count($users) > 0)
                    <table class="table table-striped">
                        <tr>
                            <th>ID</th>
                            <th>Role</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th></th>
                            <th></th>
                        </tr>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    {{$user->id}}
                                </td>
                                <td>
                                    {{$user->role}}
                                </td>
                                <td>
                                    <a href="/users/{{$user->id}}">
                                        {{$user->name}}
                                    </a>
                                </td>
                                <td>
                                    {{$user->email}}
                                </td>
                                <td>
                                    {{$user->created_at}}
                                </td>
                                <td>
                                    {{$user->updated_at}}
                                </td>
                                <td>
                                    @if($user->role === 'user' || $user->role === 'mod')
                                        @if($user->banned === 0)
                                            <a class="btn btn-warning" href="" onclick="
                                                event.preventDefault();
                                                if(confirm('Ban user?')) {
                                                    document.getElementById('user-ban-form-{{$user->id}}').submit();
                                                }
                                            ">
                                                Ban
                                            </a>
                                        @elseif($user->banned === 1)
                                            <a class="btn btn-warning" href="" onclick="
                                                event.preventDefault();
                                                if(confirm('Resume user?')) {
                                                    document.getElementById('user-ban-form-{{$user->id}}').submit();
                                                }
                                            ">
                                                Resume
                                            </a>
                                        @endif
                                        {!! Form::open(['action' => ['UsersController@ban'], 'method' => 'POST', 'id' => 'user-ban-form-' . $user->id]) !!}
                                            {!! Form::hidden('id', $user->id) !!}
                                        {!! Form::close() !!}
                                    @endif
                                </td>
                                <td>
                                    @if($user->role === 'user' || $user->role === 'mod')
                                        <a class="btn btn-danger pull-right" href="" onclick="
                                            event.preventDefault();
                                            if(confirm('Delete user?')) {
                                                document.getElementById('user-delete-form-{{$user->id}}').submit();
                                            }
                                        ">
                                            Delete
                                        </a>
                                        {!! Form::open(['action' => ['UsersController@destroy', $user->id], 'method' => 'DELETE', 'id' => 'user-delete-form-' . $user->id]) !!}
                                        {!! Form::close() !!}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{$users->links()}}
                @else
                    <p>No banned users found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection