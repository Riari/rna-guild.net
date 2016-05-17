@extends('app')

@section('title', 'Events')

@section('content')
{!! $calendar->calendar() !!}
@stop

@section('bottom')
{!! $calendar->script() !!}
@stop
