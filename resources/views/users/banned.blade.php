@extends('layouts.adminpanel.app')

@section('title', __('users.banned_users'))

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{ __('users.banned_users') }}</div>

    <div class="panel-body">
        @if(count($users) > 0)
            <table class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>{{ __('users.role') }}</th>
                    <th>{{ __('users.name') }}</th>
                    <th>{{ __('users.email_address') }}</th>
                    <th>{{ __('posts.created_at') }}</th>
                    <th>{{ __('posts.updated_at') }}</th>
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
                                <a class="btn btn-warning" href="" onclick="
                                    event.preventDefault();
                                    if(confirm('{{ __("users.resume_question") }}')) {
                                        document.getElementById('user-ban-form-{{$user->id}}').submit();
                                    }
                                ">
                                    {{ __('users.resume') }}
                                </a>
                                {!! Form::open(['action' => ['UsersController@ban'], 'method' => 'POST', 'id' => 'user-ban-form-' . $user->id]) !!}
                                    {!! Form::hidden('id', $user->id) !!}
                                {!! Form::close() !!}
                            @endif
                        </td>
                        <td>
                            @if($user->role === 'user' || $user->role === 'mod')
                                <a class="btn btn-danger pull-right" href="" onclick="
                                    event.preventDefault();
                                    if(confirm('{{ __("users.delete_question") }}')) {
                                        document.getElementById('user-delete-form-{{$user->id}}').submit();
                                    }
                                ">
                                    {{ __('users.delete') }}
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
            <p>{{ __('users.no_banned_users_found') }}</p>
        @endif
    </div>
</div>
@endsection
