@extends('admin.master')

@section('title', 'Admin Dashboard')

@section('content')
@foreach ($links as $url => $label)
    <a href="{{ url("admin/{$url}") }}" class="waves-effect waves-light btn-large">{{ $label }}</a>
@endforeach
@stop
