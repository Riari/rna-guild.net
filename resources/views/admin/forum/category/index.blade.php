@extends('admin.master')

@section('title', 'Forum Categories')

@section('breadcrumbs')
@parent
<span class="breadcrumb">Forum</span>
<span class="breadcrumb">Categories</span>
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
                        &nbsp; <a href="{{ route('admin.resource.delete', ['Forum\\Category', $category->id])}}">Delete</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@stop
