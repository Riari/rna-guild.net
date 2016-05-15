@extends('emails.base')

@section('body')
<p>Hello,</p>

<p>You or someone you know has requested a password reset for the TRN site account associated with this email address. You can follow the link below to change the password.</p>

<p><a href="{{ $link = url('auth/password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a></p>

<p>
    Sincerely,<br>
    Messenger of The Rusty Nails
</p>
@endsection
