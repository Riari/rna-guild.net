@extends('app')

@section('title', $user->name)

@section('content')
<div class="row">
    <div class="col s12 m6 l3">
        <h3>Rank</h3>

        @foreach (Auth::user()->roles as $role)
            <strong style="color:{{ $role->colour }}">{{ $role->name }}</strong><br>
        @endforeach

        <h3>Stats</h3>

        <strong>Joined:</strong> {{ Auth::user()->created_at->diffForHumans() }}
    </div>
    <div class="col s12 m6 l9">
        <h3>About</h3>

        {!! Markdown::convertToHtml($user->profile->about) !!}

        <hr>

        <h3>Signature</h3>

        {{ $user->profile->signature }}
    </div>
</div>
@endsection
