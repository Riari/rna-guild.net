@extends('admin.master')

@section('title', 'Articles')

@section('breadcrumbs')
@parent
<span class="breadcrumb">Articles</span>
@append

@section('content')
<div class="right-align">
    <a href="{{ route('admin.article.create') }}" class="waves-effect waves-light btn-large">
        Create article
    </a>
</div>
<table class="bordered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Created</th>
            <th>Published</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($articles as $article)
            <tr>
                <td>{{ $article->title }}</td>
                <td>{{ $article->author->name }}</td>
                <td>{{ $article->created_at }}</td>
                <td>{{ $article->published_at }}</td>
                <td class="right-align">
                    <a href="{{ route('admin.article.edit', $article->id) }}">Edit</a> &nbsp; <a href="{{ route('admin.resource.delete', ['Article', $article->id]) }}">Delete</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@stop
