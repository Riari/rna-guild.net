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
        <p>Starts: {{ $event->starts }} <span class="grey-text text-lighten-1">({{ $event->starts->diffForHumans() }})</span></p>
        <p>Ends: {{ $event->ends }} <span class="grey-text text-lighten-1">({{ $event->ends->diffForHumans() }})</span></p>
        @if ($event->all_day)
            <p>(All day event)</p>
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
@include('partials.add-comment', ['model' => 'Event', 'id' => $event->id])
@include('partials.comment-list')
@stop
