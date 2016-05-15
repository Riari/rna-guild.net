@extends('app')

@section('title', 'Password reset')

@section('content')
<div class="row">
    <div class="col m6 offset-m3">
        <form method="POST" action="{{ url('auth/password/reset') }}">
            {!! csrf_field() !!}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="row">
                <div class="input-field col s12">
                    <input id="email" name="email" type="email" value="{{ $email or old('email') }}" class="validate">
                    <label for="email" data-error="Please enter a valid email address">Email address</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="password" name="password" type="password">
                    <label for="password">Password</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="password_confirmation" name="password_confirmation" type="password">
                    <label for="password_confirmation">Password (confirm)</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12 right-align">
                    <button type="submit" class="waves-effect waves-light btn-large">
                        Proceed
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
