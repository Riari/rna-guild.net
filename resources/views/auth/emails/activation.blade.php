@extends('email.base')

@section('body')
<p>Hello {{ $activation->user->name }},</p>

<p>You or someone you know signed up for an account on The Rusty Nails using this email address. You can follow the link below to activate the account.</p>

<p><a href="{{ route('auth.get.activation', $activation->token) }}">{{ route('auth.get.activation', $activation->token) }}</a></p>

<p>
    Sincerely,<br>
    Messenger of The Rusty Nails
</p>
@endsection
