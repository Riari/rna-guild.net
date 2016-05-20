@extends('email.base')

@section('body')
<p>Hello {{ $user->name }},</p>

<p>The email address on your RNA site account has been changed to <strong>{{ $email }}</strong>. If you didn't do this, contact an officer ASAP.</p>

<p>
    Sincerely,<br>
    Messenger of The Rusty Nails
</p>
@endsection
