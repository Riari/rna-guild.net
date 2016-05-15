@extends('app')

@section('title', 'Your account')
@section('subtitle', "That's a nice account you have there. It would be a shame if something happened to it…")

@section('content')
<div class="row">
    <div class="col s12 m6 l4 offset-l2">
        <h3>Account details</h3>

        <strong>Name:</strong> {{ Auth::user()->name }}<br>
        <strong>Email address:</strong> {{ Auth::user()->email }}<br>
        <strong>Joined:</strong> {{ Auth::user()->created_at->diffForHumans() }}

        <h3>Rank</h3>

        @include('user.partials.rank-list', ['user' => Auth::user()])

        <h3>Third party logins</h3>

        <ul class="collection">
            @foreach (config('auth.login_providers') as $key => $provider)
                <li class="collection-item">
                    <strong class="brand-{{ $key }}-text">{{ $provider }}</strong>
                    @if ($auths->where('provider', $key)->first())
                        <a href="{{ url("account/{$key}/disconnect") }}" class="pull-right">Disconnect</a>
                    @else
                        <a href="{{ url("auth/{$key}") }}" class="pull-right">Connect</a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
    <div class="col s12 m6 l4">
        <h3>Credentials</h3>
        <form method="post" action="{{ route('account.settings') }}">
            {!! csrf_field() !!}

            <div class="row">
                <div class="input-field col s12">
                    <input id="password" name="current_password" type="password">
                    <label for="password">Current password</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="Enter a new email address to change" class="validate">
                    <label for="email" data-error="Please enter a valid email address">Email address</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="password" name="password" type="password" placeholder="Enter a new password to change">
                    <label for="password">Password</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="password_confirmation" name="password_confirmation" type="password">
                    <label for="password_confirmation">Password (confirm)</label>
                </div>
            </div>

            <div class="right-align">
                <button type="submit" class="waves-effect waves-light btn-large">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
