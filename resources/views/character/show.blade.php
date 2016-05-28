@extends('app')

@section('title', $character->name)
@section('subtitle', $character->user->profile->family_name)

@section('breadcrumbs')
<a href="{{ url('characters') }}" class="breadcrumb">Characters</a>
<span class="breadcrumb">{{ $character->name }}</span>
@stop

@section('content')
<div class="row">
    <div class="col s12 right-align">
        @can('edit', $character)
            <a href="{{ route('character.edit', compact('character')) }}">Edit</a>
        @endcan
        @can('delete', $character)
            <form class="inline" method="post" action="{{ route('character.delete', compact('character')) }}">
                {!! csrf_field() !!}
                {!! method_field('delete') !!}

                &nbsp; <button type="submit" data-confirm data-text="Are you sure you want to delete this character? The portrait and all comments will be permanently removed." class="btn btn-link">Delete</button>
            </form>
        @endcan
    </div>
</div>
<div class="row">
    <div class="col s12 m12 l3">
        <div class="character-panel">
            <img src="{{ $character->portraitUrl }}" alt="{{ $character->name }}'s portrait" class="portrait">
            <h5 class="class grey-text">
                {{ $character->gameClass->name }}
            </h5>
            <img src="{{ $character->gameClass->iconUrl }}">
            @if ($character->age || $character->occupation)
                <div class="details grey-text">
                    @if ($character->age)<strong>Age:</strong> {{ $character->age }}<br>@endif
                    @if ($character->occupation)<strong>Occupation:</strong> {{ $character->occupation }}<br>@endif
                </div>
            @endif
        </div>
    </div>
    <div class="col s12 m12 l9">
        {!! Markdown::convertToHtml($character->description) !!}
    </div>
</div>
@stop

@section('after_content')
@include('comment.partials.add', ['model' => 'Character', 'id' => $character->id])
@include('comment.partials.list')
@stop
