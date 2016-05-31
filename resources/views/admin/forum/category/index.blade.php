@extends('admin.master')

@section('title', 'Forum Categories')

@section('breadcrumbs')
@parent
<span class="breadcrumb">Forum</span>
<a href="{{ url('admin/forum/category') }}" class="breadcrumb">Categories</a>
@append

@section('content')
<table class="responsive-table bordered">
    <thead>
        <tr>
            <th>Category</th>
            <th>Description</th>
            <th>Weight</th>
            <th>Threads</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $category)
            <tr>
                <td>{{ $category->title }}</td>
                <td>{{ $category->description }}</td>
                <td>{{ $category->weight }}</td>
                <td>{{ $category->threads->count() }}</td>
                <td class="right-align">
                    <a href="#">Edit</a>
                    @if ($category->children->isEmpty() && $category->threads->isEmpty())
                        @include('admin.partials.delete-link', ['model' => 'Forum\Category', 'id' => $category->id, 'text' => "Are you sure you want to delete {$category->title}?"])
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@stop
