@extends('app')

@section('body_class', 'characters')

@section('title', 'Member Characters')

@section('content')
@can('createCharacters')
    <div class="row">
        <div class="col s12">
                <a href="{{ route('character.create') }}" class="waves-effect waves-light btn btn-large">
                    Add a character
                </a>
        </div>
    </div>
@endcan
<div class="row">
    @foreach ($paginator->items() as $character)
        <div class="col s6 m4 l2 character center-align">
            <h4>
                <a href="{{ $character->url }}">
                    {{ $character->name }}
                </a>
            </h4>
            <p>
                <a href="{{ $character->user->profile->url }}">
                    @if (empty($character->user->profile->family_name))
                        {{ $character->user->name }}
                    @else
                        {{ $character->user->profile->family_name }}
                    @endif
                </a>
            </p>
            <div class="character-panel">
                <a href="{{ $character->url }}">
                    <img src="{{ $character->portraitUrl }}" alt="{{ $character->name }}'s portrait" class="portrait">
                </a>
                <h5 class="grey-text">{{ $character->gameClass->name }}</h5>
                <img src="{{ $character->gameClass->iconUrl }}">
            </div>
        </div>
    @endforeach

    @include('partials.pagination')
</div>
@stop
