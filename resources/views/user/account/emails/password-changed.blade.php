@extends('emails.base')

@section('body')
<p>Hello {{ $user->name }},</p>

<p>The password on your TNA site account has been changed. If you didn't do this, contact an officer ASAP.</p>

<p>
    Sincerely,<br>
    Messenger of The Rusty Nails
</p>
@endsection
