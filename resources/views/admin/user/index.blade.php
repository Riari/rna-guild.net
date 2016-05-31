@extends('admin.master')

@section('title', 'Users')

@section('breadcrumbs')
@parent
<span class="breadcrumb">Users</span>
@append

@section('content')
<div class="right-align">
    <a href="{{ route('admin.user.create') }}" class="waves-effect waves-light btn-large">
        Create user
    </a>
</div>
<table class="bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Rank(s)</th>
            <th>Created</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>
                    {{ $user->name }}
                    @if ($user->isNew)
                        &nbsp; <strong class="red-text">New</strong>
                    @endif
                </td>
                <td>{{ $user->email }}</td>
                <td class="{{ !$user->activated ? 'red-text' : 'teal-text' }}">
                    {{ $user->activated ? 'Activated' : 'Not activated' }}
                </td>
                <td>{{ $user->roleList }}</td>
                <td>{{ $user->created_at }}</td>
                <td class="right-align">
                    <a href="{{ route('admin.user.edit', $user->id) }}">Edit</a> &nbsp; <a href="{{ route('admin.resource.delete', ['User', $user->id]) }}">Delete</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@stop
