@extends('admin.master')

@section('title', 'Forum Categories')

@section('breadcrumbs')
@parent
<span class="breadcrumb">Forum</span>
<a href="{{ url('admin/forum/category') }}" class="breadcrumb">Categories</a>
@append

@section('content')
<div class="row">
    <div class="col s12 m8 l9">
        <div class="alert info">
            Tip: Existing categories can be modified and deleted (if they're empty) when viewing them directly.<br>
            Here, you can create new categories and re-structure existing ones by dragging them (remember to hit 'Save order' below the list after doing so).
        </div>
    </div>
    <div class="col s12 m4 l3 right-align">
        <a href="{{ route('admin.forum.category.create') }}" class="waves-effect waves-light btn btn-large">Create category</a>
    </div>
</div>
<form method="post" action="{{ route('admin.forum.category.reorder') }}">
    {!! csrf_field() !!}

    <ol data-sortable>
        @foreach ($categories as $category)
            @include('admin.forum.category.partials.row')
        @endforeach
    </ol>

    <div class="right-align">
        <button type="submit" class="waves-effect waves-light btn-large disabled" disabled data-sortable-submit>Save order</button>
    </div>
</form>
@stop
