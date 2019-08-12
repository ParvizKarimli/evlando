@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Users</div>

            <div class="panel-body">

                <p><a href="/dashboard" class="btn btn-primary">Dashboard</a></p>

                <h3>Users</h3>
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
                                    <a class="btn btn-warning pull-right" href="/users/{{$user->id}}/edit">
                                        Edit
                                    </a>
                                </td>
                                <td>
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
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{$users->links()}}
                @else
                    <p>No users found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
