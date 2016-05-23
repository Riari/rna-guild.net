@extends('app')

@section('title', 'Viewing image album')
@section('subtitle', "{$album->title} by {$album->user->displayName}")

@section('breadcrumbs')
<a href="{{ url('gallery') }}" class="breadcrumb">Image Gallery</a>
<span class="breadcrumb">{{ $album->title }}</span>
@stop

@section('content')
<div class="row">
    <div class="col s12">
        <div class="right-align">
            @can('edit', $album)
                <a href="{{ route('image-album.edit', compact('album')) }}">Edit</a>
            @endcan
            @can('delete', $album)
                <form class="inline" method="post" action="{{ route('image-album.delete', compact('album')) }}">
                    {!! csrf_field() !!}
                    {!! method_field('delete') !!}

                    &nbsp; <button type="submit" data-confirm data-text="Are you sure you want to delete this album? All of its images and comments will be permanently removed." class="btn btn-link">Delete</button>
                </form>
            @endcan
        </div>

        {!! Markdown::convertToHtml($album->description) !!}

        <div class="slider">
            <ul>
                @foreach ($album->attachments()->orderBy('key')->get() as $image)
                    <li>
                        <a href="{{ $image->getDownloadUrl() }}" class="btn download">
                            Download
                        </a>
                        <img src="{{ $image->getUrl() }}" alt="{{ $image->title }}">
                        <span class="caption">{{ $image->title }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        @include('partials.tag-list', ['model' => $album])
    </div>
</div>
@stop

@section('after_content')
@include('comment.partials.add', ['model' => 'ImageAlbum', 'id' => $album->id])
@include('comment.partials.list')
@stop
