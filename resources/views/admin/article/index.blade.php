@extends('admin.master')

@section('title', 'Articles')

@section('breadcrumbs')
@parent
<a href="{{ url('admin/article') }}" class="breadcrumb">Articles</a>
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
            <th>#</th>
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
                <td>{{ $article->id }}</td>
                <td>{{ $article->title }}</td>
                <td>{{ $article->user->name }}</td>
                <td>{{ $article->created_at }}</td>
                <td>{{ $article->published_at }}</td>
                <td class="right-align">
                    <a href="{{ route('admin.article.edit', $article->id) }}">Edit</a>
                    @include('admin.partials.delete-link', ['model' => 'Article', 'id' => $article->id, 'text' => "Are you sure you want to delete {$article->title}?"])
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@stop
