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
                <td><a href="{{ $event->user->profile->url }}">{{ $event->user->name }}</a></td>
                <td>{{ $event->created }}</td>
                <td>{{ $event->starts }}</td>
                <td>{{ $event->ends }}</td>
                <td class="right-align">
                    <a href="{{ route('admin.event.edit', $event->id) }}">Edit</a>
                    @include('partials.delete-link', ['id' => $event->id])
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@include('partials.pagination')

@foreach ($paginator->items() as $event)
    @include('admin.partials.delete-modal', ['id' => $event->id, 'model' => 'Event', 'model_id' => $event->id, 'text' => "Are you sure you want to delete {$event->title}?"])
@endforeach
@stop
