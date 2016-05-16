@extends('admin.master')

@section('title', 'Admin Dashboard')

@section('content')
<a href="{{ url('admin/article') }}" class="waves-effect waves-light btn-large">Articles</a>
<a href="{{ url('admin/forum/category') }}" class="waves-effect waves-light btn-large">Forum Categories</a>
@stop
