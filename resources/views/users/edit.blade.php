@extends('layouts.adminpanel.app')

@section('title', __('users.edit_user') . ' - ' . auth()->user()->name)

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{ __('users.edit_user') }}</div>

    <div class="panel-body">
        {!! Form::open(['action' => ['UsersController@update', auth()->user()->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-2 control-label">{{ __('users.name') }}</label>

                <div class="col-md-4">
                    <input id="name" type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" required autofocus>

                    @if ($errors->has('name'))
                    <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-2 control-label">{{ __('users.email_address') }}</label>

                <div class="col-md-4">
                    <input id="email" type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" required>

                    @if ($errors->has('email'))
                    <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-2 control-label">{{ __('users.password') }}</label>

                <div class="col-md-4">
                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                    <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="password-confirm" class="col-md-2 control-label">{{ __('users.confirm_password') }}</label>

                <div class="col-md-4">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('users.update') }}
                    </button>
                </div>
            </div>
        {!! Form::close() !!}

        @if(auth()->user()->role === 'user' || auth()->user()->role === 'mod')
            <a class="btn btn-danger pull-right" href="" onclick="
                event.preventDefault();
                if(confirm('{{ __("users.delete_user_question") }}')) {
                    document.getElementById('user-delete-form').submit();
                }
            ">
                {{ __('users.delete_user') }}
            </a>
            {!! Form::open(['action' => ['UsersController@destroy', auth()->user()->id], 'method' => 'DELETE', 'id' => 'user-delete-form']) !!}
            {!! Form::close() !!}
        @endif
    </div>
</div>
@endsection
