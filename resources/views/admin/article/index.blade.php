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
        @foreach ($paginator->items() as $article)
            <tr>
                <td>{{ $article->id }}</td>
                <td><a href="{{ $article->url }}">{{ $article->title }}</a></td>
                <td><a href="{{ $article->user->profile->url }}">{{ $article->user->name }}</a></td>
                <td>{{ $article->created }}</td>
                <td>{{ $article->published }}</td>
                <td class="right-align">
                    <a href="{{ route('admin.article.edit', $article->id) }}">Edit</a>
                    @include('partials.delete-link', ['id' => $article->id])
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@include('partials.pagination')

@foreach ($paginator->items() as $article)
    @include('admin.partials.delete-modal', ['id' => $article->id, 'model' => 'Article', 'model_id' => $article->id, 'text' => "Are you sure you want to delete {$article->title}?"])
@endforeach
@stop
