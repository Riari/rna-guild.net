@extends('app')

@section('title', 'Register')
@section('subtitle', "If you don't, you're a BUTT")

@section('content')
<div class="row">
    <div class="col s12 {{ session('pending_user_auth') ? 'm12 l8' : 'm6 l4' }} offset-l2">
        <form role="form" method="POST" action="{{ url('auth/register') }}">
            {!! csrf_field() !!}

            @if (session('pending_user_auth'))
                <div class="alert success">
                    Almost done! Just finish registration below, or if you want to associate your {{ session('pending_user_auth_provider') }} account with an existing TRN one, <a href="{{ url('auth/login') }}">log in</a> first.
                </div>
            @endif

            <div class="row">
                <div class="input-field col s12">
                    <input id="name" name="name" type="text" value="{{ (is_null(old('name')) && session('pending_user_auth')) ? session('pending_user_auth')->nickname : old('name') }}" autofocus="true">
                    <label for="name">Name</label>
                    <span class="grey-text">This is the name displayed throughout the site (family name can be set through your profile after registering). Spaces are allowed.</span>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="email" name="email" type="email" value="{{ (is_null(old('email')) && session('pending_user_auth')) ? session('pending_user_auth')->email : old('email') }}" class="validate">
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
    @if (!session('pending_user_auth'))
        <div class="col s12 m6 l4">
                <p><strong>Alternatively, sign up via...</strong></p>

                <hr>

                @foreach (config('auth.login_providers') as $key => $provider)
                    <p><a href="{{ url("auth/{$key}") }}" class="waves-effect waves-light btn-large block brand-{{ $key }}">{{ $provider }} :D</a></p>
                @endforeach
        </div>
    @endif
</div>
@endsection
