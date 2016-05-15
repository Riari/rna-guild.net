@extends('app')

@section('title', 'Rusty Nails Adventurers')
@section('subtitle', "<em>{$quote}</em>")

@section('content')
<div class="row">
    <div class="col m12">
        @if (Auth::check())
            <strong><span style="color:{{ Auth::user()->roles->first()->colour }};">{{ Auth::user()->roles->first()->name }}</span></strong>
        @endif
    </div>
</div>
@endsection
