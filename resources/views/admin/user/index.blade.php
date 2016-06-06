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
        @foreach ($paginator->items() as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>
                    {{ $user->name }}
                    @if (!$user->approved)
                        &nbsp; <strong class="red-text">Unapproved</strong>
                    @endif
                </td>
                <td>{{ $user->email }}</td>
                <td class="{{ !$user->confirmed ? 'orange-text' : 'teal-text' }}">
                    {{ $user->confirmed ? 'Confirmed' : 'Unconfirmed' }}
                </td>
                <td>{{ $user->roleList }}</td>
                <td>{{ $user->created }}</td>
                <td class="right-align">
                    <a href="{{ $user->profile->url }}">View profile</a> &nbsp;
                    <a href="{{ route('admin.user.edit', $user->id) }}">Edit</a>
                    @include('partials.delete-link', ['id' => $user->id])
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@include('partials.pagination')

@foreach ($paginator->items() as $user)
    @include('admin.partials.delete-modal', ['id' => $user->id, 'model' => 'User', 'model_id' => $user->id, 'text' => "Are you sure you want to delete {$user->name}? All of their content on the site will be removed if you do this!"])
@endforeach
@stop
