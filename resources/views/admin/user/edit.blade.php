@extends('admin.master')

@section('title', $user->exists ? 'Edit User' : 'Create User')

@section('breadcrumbs')
@parent
<span class="breadcrumb">Users</span>
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
                    <input id="name" name="name" type="text" value="{{ !empty(old('name')) ? old('name') : $user->name }}">
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
                        Tip: Users with the 'New user' role have read only access to limited parts of the site.<br>
                        Guild Master, Officer and Webmaster roles grant admin rights.
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input type="hidden" name="activated" value="0">
                    <input type="checkbox" class="filled-in" id="activated" name="activated" value="1" {{ (old('activated') || $user->activated) ? 'checked' : '' }}>
                    <label for="activated">Activate (non-activated users have limited access)</label>
                </div>
            </div>

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
