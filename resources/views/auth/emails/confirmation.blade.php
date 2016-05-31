@extends('email.base')

@section('body')
<p>Hello {{ $confirmation->user->name }},</p>

<p>You or someone you know signed up for an account on the Rusty Nails website using this email address. You can follow the link below to confirm the account.</p>

<p><a href="{{ route('auth.get.confirmation', $confirmation->token) }}">{{ route('auth.get.confirmation', $confirmation->token) }}</a></p>

<p>
    Sincerely,<br>
    Messenger of The Rusty Nails
</p>
@endsection
