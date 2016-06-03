@extends('email.base')

@section('body')
<p>Hello {{ $user->name }},</p>

<p>{{ $notification->text }}:</p>

<p><a href="{{ $notification->url }}">{{ $notification->url }}</a></p>

<p>
    Sincerely,<br>
    Messenger of The Rusty Nails
</p>
@endsection
