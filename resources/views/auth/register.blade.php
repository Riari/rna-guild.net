@extends('app')

@section('title', 'Register')
@section('subtitle', "If you don't, you're a BUTT")

@section('content')
<div class="row">
    <div class="col s12 {{ session('pending_user_auth') ? 'm12 l8' : 'm6 l4' }} offset-l2">
        <form  role="form" method="POST" action="{{ url('auth/register') }}">
            {!! csrf_field() !!}

            @if (Session::has('pending_user_auth'))
                <div class="alert success">
                    Almost done! Just finish registration below, or if you want to associate
                </div>
            @endif

            <div class="row">
                <div class="input-field col s12">
                    <input id="name" name="name" type="text" value="{{ (is_null(old('name')) && session('pending_user_auth')) ? session('pending_user_auth')->nickname : old('name') }}">
                    <label for="name">Name</label>
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

                <p><a href="{{ url('auth/facebook') }}" class="waves-effect waves-light btn-large block brand-facebook">Facebook :D</a></p>
                <p><a href="{{ url('auth/twitter') }}" class="waves-effect waves-light btn-large block brand-twitter">Twitter :D</a></p>
                <p><a href="{{ url('auth/google') }}" class="waves-effect waves-light btn-large block brand-google">Google :D</a></p>
        </div>
    @endif
</div>
@endsection
