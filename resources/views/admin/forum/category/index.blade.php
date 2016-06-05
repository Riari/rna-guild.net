@extends('admin.master')

@section('title', 'Forum Categories')

@section('breadcrumbs')
@parent
<span class="breadcrumb">Forum</span>
<a href="{{ url('admin/forum/category') }}" class="breadcrumb">Categories</a>
@append

@section('content')
<div class="alert info">
    Tip: Drag a category to change its position in the list.
</div>
<form method="post" action="{{ route('admin.forum.category.reorder') }}">
    {!! csrf_field() !!}

    <button type="submit" class="waves-effect waves-light btn-large disabled pull-right" disabled data-sortable-submit>Save order</button>
    <a href="{{ route('admin.forum.category.create') }}" class="waves-effect waves-light btn btn-large">Create category</a>

    <ol data-sortable>
        @foreach ($categories as $category)
            @include('admin.forum.category.partials.row')
        @endforeach
    </ol>

    <div class="right-align">
        <button type="submit" class="waves-effect waves-light btn-large disabled" disabled data-sortable-submit>Save order</button>
    </div>
</form>

@foreach (\App\Models\Forum\Category::all() as $category)
    @if ($category->children->isEmpty() && $category->threads->isEmpty())
        @include('admin.partials.delete-modal', ['id' => $category->id, 'model' => 'Forum\Category', 'model_id' => $category->id, 'text' => "Are you sure you want to delete category {$category->title}?"])
    @endif
@endforeach
@stop
