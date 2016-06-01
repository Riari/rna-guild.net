@extends('admin.master')

@section('title', 'Events')

@section('breadcrumbs')
@parent
<a href="{{ url('admin/event') }}" class="breadcrumb">Events</a>
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
        @foreach ($paginator->items() as $event)
            <tr>
                <td>{{ $event->id }}</td>
                <td><a href="{{ $event->url }}">{{ $event->title }}</a></td>
                <td>{{ $event->user->name }}</td>
                <td>{{ $event->created_at }}</td>
                <td>{{ $event->starts }}</td>
                <td>{{ $event->ends }}</td>
                <td class="right-align">
                    <a href="{{ route('admin.event.edit', $event->id) }}">Edit</a>
                    @include('admin.partials.delete-link', ['model' => 'Event', 'id' => $event->id, 'text' => "Are you sure you want to delete {$event->title}?"])
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@include('partials.pagination')
@stop
