@extends('admin.master')

@section('title', 'Events')

@section('breadcrumbs')
@parent
<span class="breadcrumb">Events</span>
@append

@section('content')
<div class="right-align">
    <a href="{{ route('admin.event.create') }}" class="waves-effect waves-light btn-large">
        Create event
    </a>
</div>
<table class="bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Author</th>
            <th>Created</th>
            <th>Starts</th>
            <th>Ends</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($events as $event)
            <tr>
                <td>{{ $event->id }}</td>
                <td><a href="{{ $event->url }}">{{ $event->title }}</a></td>
                <td>{{ $event->user->name }}</td>
                <td>{{ $event->created_at }}</td>
                <td>{{ $event->starts }}</td>
                <td>{{ $event->ends }}</td>
                <td class="right-align">
                    <a href="{{ route('admin.event.edit', $event->id) }}">Edit</a> &nbsp; <a href="{{ route('admin.resource.delete', ['Event', $event->id]) }}">Delete</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@stop
