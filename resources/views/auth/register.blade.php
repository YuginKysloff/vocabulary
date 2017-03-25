@extends('layouts.app')

@section('content')
    <div class="page__wrapper">
        <h1 class="page__title">Register</h1>
        <form class="auth__form" role="form" method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="auth__label">Name</label>
                <div class="col-md-6">
                    <input id="name" type="text" class="auth__input" name="name" value="{{ old('name') }}" required autofocus>

                    @if ($errors->has('name'))
                        <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="auth__label">E-Mail Address</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="auth__input" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="auth__label">Password</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="auth__input" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="password-confirm" class="auth__label">Confirm Password</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="auth__input" name="password_confirmation" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="auth__button">
                        Register
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
