@extends('admin.master')

@section('title', $user->exists ? 'Edit User' : 'Create User')

@section('breadcrumbs')
@parent
<a href="{{ url('admin/user') }}" class="breadcrumb">Users</a>
<span class="breadcrumb">
    @if ($user->exists)
        Edit
    @else
        Create
    @endif
</span>
@append

@section('content')
<div class="row">
    <div class="col m8 offset-m2">
        <form method="POST" action="{{ route($user->exists ? 'admin.user.update' : 'admin.user.store', $user->id) }}">
            {!! csrf_field() !!}
            @if ($user->exists)
                {!! method_field('PATCH') !!}
            @endif

            <div class="row">
                <div class="input-field col s12">
                    <input id="name" name="name" type="text" value="{{ !empty(old('name')) ? old('name') : $user->name }}" autofocus="true">
                    <label for="name">Name</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="email" name="email" type="email" value="{{ !empty(old('email')) ? old('email') : $user->email }}" class="validate">
                    <label for="email">Email address</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="password" name="password" type="password" @if ($user->exists)placeholder="Enter a new password to change"@endif>
                    <label for="password">Password</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="password_confirmation" name="password_confirmation" type="password">
                    <label for="password_confirmation">Password (confirm)</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <select name="roles[]" multiple>
                        @foreach ($roles as $id => $name)
                            <option value="{{ $id }}" {{ $user->hasRole($name) ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    <label>Role(s)</label>
                    <div class="alert info">
                        Tip: Guild Master, Officer and Webmaster roles grant admin rights.
                    </div>
                </div>
            </div>
            @if ($user->exists)
                <div class="row">
                    <div class="input-field col s6">
                        <input type="hidden" name="confirmed" value="0">
                        <input type="checkbox" class="filled-in" id="confirmed" name="confirmed" value="1" {{ (old('confirmed') || $user->confirmed) ? 'checked' : '' }}>
                        <label for="confirmed">Confirm</label>
                    </div>
                    <div class="input-field col s6">
                        <input type="hidden" name="approved" value="0">
                        <input type="checkbox" class="filled-in" id="approved" name="approved" value="1" {{ (old('approved') || $user->approved) ? 'checked' : '' }}>
                        <label for="approved">Approve</label>
                    </div>
                </div>

                <div class="alert info">
                    A user must be both <strong>confirmed</strong> and <strong>approved</strong> to gain proper access to the site:
                    <ul>
                        <li><strong>Confirm</strong> indicates whether or not the user's email address is confirmed.</li>
                        <li><strong>Approve</strong> indicates that the user is a recognised member or friend of RNA.</li>
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="input-field col s12 right-align">
                    <button type="submit" class="waves-effect waves-light btn-large">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop
