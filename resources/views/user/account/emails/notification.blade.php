@extends('email.base')

@section('body')
<p>Hello {{ $user->name }},</p>

<p>{{ $notification->notifyBody }}:</p>

<p><a href="{{ $notification->url }}">{{ $notification->url }}</a></p>

<p style="color:#aaa;">(You received this email because you have 'Enable notifications via email' set in your account settings: <a href="{{ url('account/settings') }}">{{ url('account/settings') }}</a>)

<p>
    Sincerely,<br>
    Messenger of The Rusty Nails
</p>
@endsection
