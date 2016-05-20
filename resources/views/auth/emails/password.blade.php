@extends('email.base')

@section('body')
<p>Hello,</p>

<p>A password reset request has been made for the RNA site account associated with this email address. If this was you, you can follow the link below to change the password.</p>

<p><a href="{{ $link = url('auth/password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a></p>

<p>
    Sincerely,<br>
    Messenger of The Rusty Nails
</p>
@endsection
