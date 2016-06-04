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
            @include('partials.delete-link', ['id' => $character->id])
            @include('partials.delete-modal', ['id' => $character->id, 'action' => route('character.delete', compact('character')), 'text' => "Are you sure you want to delete this character?"])
        @endcan
    </div>
</div>
<div class="row">
    <div class="col s12 m4 l3">
        <div class="character-panel">
            <img src="{{ $character->portraitUrl }}" alt="{{ $character->name }}'s portrait" class="portrait">
            <h5 class="class grey-text">
                {{ $character->gameClass->name }}
            </h5>
            <img src="{{ $character->gameClass->iconUrl }}">
            <div class="details grey-text">
                @if ($character->age)<strong>Age:</strong> {{ $character->age }}<br>@endif
                @if ($character->occupation)<strong>Occupation:</strong> {{ $character->occupation }}<br>@endif
                <strong>Played by:</strong> <a href="{{ $character->user->profile->url }}">{{ $character->user->displayName }}</a>
            </div>
        </div>
    </div>
    <div class="col s12 m8 l9">
        {!! Markdown::convertToHtml($character->description) !!}
    </div>
</div>
@stop

@section('after_content')
@can('addComment', $character)
    @include('comment.partials.add', ['model' => 'Character', 'id' => $character->id])
@endcan
@include('comment.partials.list')
@stop
