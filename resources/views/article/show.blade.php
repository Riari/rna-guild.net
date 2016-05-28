@extends('app')

@section('title', $article->title)
@section('subtitle')
Published by
<a href="{{ $article->user->profile->url }}">{{ $article->user->name }}</a>
{{ $article->published_at->diffForHumans() }}
@stop

@section('breadcrumbs')
<span class="breadcrumb">Articles</span>
<span class="breadcrumb">{{ $article->title }}</span>
@stop

@section('content')
<div class="row">
    <div class="col s12 m12 l8 offset-l2">
        {!! Markdown::convertToHtml($article->body) !!}
    </div>
</div>
@stop

@section('after_content')
@include('comment.partials.add', ['model' => 'Article', 'id' => $article->id])
@include('comment.partials.list')
@stop
