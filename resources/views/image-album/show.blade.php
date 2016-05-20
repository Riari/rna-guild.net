@extends('app')

@section('body_class', 'gallery')

@section('title', 'Viewing image album')
@section('subtitle', $album->title)

@section('breadcrumbs')
<a href="{{ url('gallery') }}" class="breadcrumb">Image Gallery</a>
<span class="breadcrumb">{{ $album->title }}</span>
@stop

@section('content')
<div class="row">
    <div class="col s12 m12 l4">
    </div>
    <div class="col s12 m12 l8">
        <h4>Details</h4>
        {!! Markdown::convertToHtml($album->description) !!}

        @foreach ($album->attachments as $image)
            <img src="{{ $image->getUrl() }}">
        @endforeach

        @include('partials.tag-list', ['model' => $album])
    </div>
</div>
@stop

@section('after_content')
@include('comment.partials.add', ['model' => 'ImageAlbum', 'id' => $album->id])
@include('comment.partials.list')
@stop
