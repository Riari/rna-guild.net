@extends('app')

@section('title', 'The Rusty Nails')
@section('subtitle', "<em>'Tis but a scratch!</em>")

@section('content')
<div class="row">
    <div class="col m12">
        @if (Auth::check())
            <strong><span style="color:{{ Auth::user()->roles->first()->colour }};">{{ Auth::user()->roles->first()->name }}</span></strong>
        @endif
    </div>
</div>
@endsection
