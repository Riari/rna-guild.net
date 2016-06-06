@extends('app')

@section('body_class', 'gallery')

@section('title', 'Image Gallery')

@section('content')
<div class="row">
    <div class="col s12">
        @can('createImageAlbums')
            <a href="{{ route('image-album.create') }}" class="waves-effect waves-light btn btn-large">
                Upload image(s)
            </a>
        @endcan
    </div>
</div>
<div class="row">
    @foreach ($paginator->items() as $album)
        <div class="col s6 m4 l3 album {{ $album->hasMultipleImages ? 'multiple-images' : '' }}">
            <a href="{{ $album->url }}">
                <span class="title">{{ $album->title }}</span>
                <img src="{{ $album->coverUrl }}" alt="{{ $album->title }}">
            </a>
            <span class="grey-text">
                by <a href="{{ $album->user->profile->url }}">{{ $album->user->displayName }}</a>
                {{ $album->createdAgo }}
            </span>
        </div>
    @endforeach
    @include('partials.pagination')
</div>
@stop
