@extends('app')

@section('title', 'Password reset')

@section('content')
<div class="row">
    <div class="col m6 offset-m3">
        @if (session('status'))
            <div class="alert success">
                {{ session('status') }}
            </div>
        @endif

        <form role="form" method="POST" action="{{ url('auth/password/email') }}">
            {!! csrf_field() !!}

            <div class="row">
                <div class="input-field col s12">
                    <input id="email" name="email" type="email" value="{{ old('email') }}" class="validate">
                    <label for="email" data-error="Please enter a valid email address">Email address</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12 right-align">
                    <button type="submit" class="waves-effect waves-light btn-large">
                        Send password reset link
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
