@extends('email.base')

@section('body')
<p>Hello {{ $user->name }},</p>

<p>Someone has created an account for you on {{ url('/') }}. You can log in at:</p>

<p><a href="{{ url('auth/login') }}">{{ url('auth/login') }}</a></p>

<p>Your details are:</p>

<p>
    <strong>Name:</strong> {{ $user->name }}<br>
    <strong>Email address:</strong> {{ $user->email }}<br>
    <strong>Password:</strong> {{ $password }} (you should probably change this after logging in!)
</p>

<p>
    Sincerely,<br>
    Messenger of The Rusty Nails
</p>
@endsection
