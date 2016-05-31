@extends('admin.master')

@section('title', 'Users')

@section('breadcrumbs')
@parent
<a href="{{ url('admin/user') }}" class="breadcrumb">Users</a>
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
            <th>Role(s)</th>
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
                    @if (!$user->approved)
                        &nbsp; <strong class="red-text">Unapproved</strong>
                    @endif
                </td>
                <td>{{ $user->email }}</td>
                <td class="{{ !$user->confirmed ? 'red-text' : 'teal-text' }}">
                    {{ $user->confirmed ? 'Confirmed' : 'Not confirmed' }}
                </td>
                <td>{{ $user->roleList }}</td>
                <td>{{ $user->created_at }}</td>
                <td class="right-align">
                    <a href="{{ route('admin.user.edit', $user->id) }}">Edit</a>
                    @include('admin.partials.delete-link', ['model' => 'User', 'id' => $user->id, 'text' => "Are you sure you want to delete {$user->name}? All of their content on the site will be removed if you do this!"])
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@stop
