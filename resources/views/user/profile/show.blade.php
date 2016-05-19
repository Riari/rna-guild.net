@extends('app')

@section('title', $user->name)

@section('before_content')
<div class="profile-avatar-container center-align">
    @include('partials.avatar', ['class' => 'circular bordered'])
</div>
@stop

@section('content')
<div class="row">
    <div class="col s12 m6 l3">
        <h3>Rank</h3>

        @foreach ($user->roles as $role)
            <strong style="color:{{ $role->colour }}">{{ $role->name }}</strong><br>
        @endforeach

        <h3>Stats</h3>

        <strong>Joined:</strong> {{ $user->created_at->diffForHumans() }}
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

@section('after_content')
@include('comments.partials.add', ['model' => 'UserProfile', 'id' => $user->profile->id])
@include('comments.partials.list', ['noComments' => "{$user->name} has no comments yet. :&#40;"])
@stop
