@extends('app')

@section('title', 'Your account')
@section('subtitle', "That's a nice account you have there. It would be a shame if something happened to it…")

@section('content')
<div class="row">
    <div class="col s12 m4 l4">
        <h3>Account details</h3>

        <strong>Name:</strong> {{ Auth::user()->name }}<br>
        <strong>Email address:</strong> {{ Auth::user()->email }}<br>
        <strong>Joined:</strong> {{ Auth::user()->created_at->diffForHumans() }}

        <h3>Roles</h3>

        @include('user.partials.role-list', ['user' => Auth::user()])

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
    <form method="post" action="{{ route('account.settings') }}">
        {!! csrf_field() !!}

        <div class="col s12 m4 l4">
            <h3>Credentials</h3>

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
        </div>
        <div class="col s12 m4 l4">
            <h3>Preferences</h3>
            <div class="row">
                <div class="col s12">
                    <div class="input-field">
                        <input type="hidden" name="preferences[comment_notifications]" value="0">
                        <input type="checkbox" class="filled-in" id="comment_notifications" name="preferences[comment_notifications]" value="1" {{ (old('preferences.comment_notifications') || Auth::user()->preference('comment_notifications', 1)) ? 'checked' : '' }}>
                        <label for="comment_notifications">Notify me of comments added to my content</label>
                    </div>
                    <div class="input-field">
                        <input type="hidden" name="preferences[email_notifications]" value="0">
                        <input type="checkbox" class="filled-in" id="email_notifications" name="preferences[email_notifications]" value="1" {{ (old('preferences.email_notifications') || Auth::user()->preference('email_notifications')) ? 'checked' : '' }}>
                        <label for="email_notifications">Enable notifications by email</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    {!! Timezone::selectForm(Auth::user()->preference('timezone', 'UTC'), 'Select a timezone', ['name' => 'preferences[timezone]']) !!}
                    <label>Timezone</label>
                </div>
            </div>
        </div>
        <div class="col s12 right-align">
            <button type="submit" class="waves-effect waves-light btn-large">Save changes</button>
        </div>
    </form>
</div>
@endsection
