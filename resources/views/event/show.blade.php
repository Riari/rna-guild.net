@extends('app')

@section('title', 'Viewing event')
@section('subtitle', $event->title)

@section('breadcrumbs')
<a href="{{ url('events') }}" class="breadcrumb">Events</a>
<span class="breadcrumb">{{ $event->title }}</span>
@stop

@section('content')
<div class="row">
    <div class="col s12 m12 l4">
        <h4>When</h4>
        @if ($event->all_day)
            <p>Starts <strong>{{ $event->startsOn() }}</strong></p>
            <p>Ends <strong>{{ $event->endsOn() }}</strong></p>
            <p class="grey-text">(All day)</p>
        @else
            <p>Starts <strong>{{ $event->startsOn() }}</strong> <span class="grey-text text-lighten-1">({{ $event->starts->diffForHumans() }})</span></p>
            <p>Ends <strong>{{ $event->endsOn() }}</strong> <span class="grey-text text-lighten-1">({{ $event->ends->diffForHumans() }})</span></p>
        @endif
        @if ($event->location)
            <h4>Where</h4>
            <p>{{ $event->location }}</p>
        @endif
    </div>
    <div class="col s12 m12 l8">
        <h4>Details</h4>
        {!! Markdown::convertToHtml($event->description) !!}

        @include('partials.tag-list', ['model' => $event])
    </div>
</div>
@stop

@section('after_content')
@can('addComment', $event)
    @include('comment.partials.add', ['model' => 'Event', 'id' => $event->id])
@endcan
@include('comment.partials.list')
@stop
