@extends('app')

@section('title', $user->name)
@section('subtitle', $user->profile->family_name)

@section('before_content')
<div class="profile-avatar-container center-align">
    @include('user.partials.avatar', ['class' => 'circular bordered'])
</div>
@stop

@section('content')
<div class="row">
    <div class="col s12 m6 l3">
        <h3>Role(s)</h3>

        @foreach ($user->roles as $role)
            <strong style="color:{{ $role->colour }}">{{ $role->name }}</strong><br>
        @endforeach

        <h3>Stats</h3>

        <strong>Joined:</strong> {{ $user->createdAgo }}
    </div>
    <div class="col s12 m6 l9">
        @if ($user->profile->about)
            <h3>About</h3>

            {!! Markdown::convertToHtml($user->profile->about) !!}
        @endif
        @if ($user->profile->signature)
            <hr>
            <h3>Signature</h3>

            {{ $user->profile->signature }}
        @endif
    </div>
</div>
@endsection

@section('after_content')
@can('addComment', $user->profile)
    @include('comment.partials.add', ['model' => 'UserProfile', 'id' => $user->profile->id])
@endcan
@include('comment.partials.list', ['noComments' => "{$user->name} has no comments yet. :&#40;"])
@stop
