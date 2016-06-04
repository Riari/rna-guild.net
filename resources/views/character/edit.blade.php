@extends('app')

@section('body_class', 'characters')

@section('title', $character->exists ? 'Edit character' : 'Create character')
@section('subtitle', $character->exists ? $character->name : '')

@section('content')
<div class="row">
    <div class="col m6 offset-m3">
        <form method="POST" action="{{ route($character->exists ? 'character.update' : 'character.store', $character->id) }}" enctype="multipart/form-data">
            {!! csrf_field() !!}
            @if ($character->exists)
                {!! method_field('PATCH') !!}
            @endif

            <div class="alert info">
                <strong>Tip:</strong> You can set your family name under your <a href="{{ url('account/profile/edit') }}">profile</a>.
            </div>

            @if (!$character->exists)
                <div class="row">
                    <div class="input-field col s12">
                        <input id="name" name="name" type="text" value="{{ !empty(old('name')) ? old('name') : $character->name }}" autofocus="true">
                        <label for="name">Name</label>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="input-field col s12">
                    <select name="class_id">
                        @foreach ($classes as $id => $name)
                            <option value="{{ $id }}" data-icon="{{ url('images/game/class/icon_' . strtolower($name) . '.png') }}" class="circle" {{ $id == $character->class_id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    <label>Class</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="age" name="age" type="text" value="{{ !empty(old('age')) ? old('age') : $character->age }}">
                    <label for="age">Age</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="occupation" name="occupation" type="text" value="{{ !empty(old('occupation')) ? old('occupation') : $character->occupation }}">
                    <label for="occupation">Occupation</label>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div class="file-field">
                        <div class="btn">
                            <span>Portrait *</span>
                            <input type="file" data-file-input name="portrait">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>

                    <p class="grey-text right-align">
                        * Portraits are scaled and cropped to fit <strong>300px by 390px</strong>.<br>
                        The class default is used if no portrait is uploaded.
                    </p>

                    @if ($character->exists && !is_null($character->portrait))
                        <p>Current:</p>
                        <img src="{{ $character->portraitUrl }}" alt="{{ $character->name }}'s portrait">
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <label>Description</label>
                    <textarea id="description" name="description" class="materialize-textarea">{{ !is_null(old('description')) ? old('description') : $character->description }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input type="hidden" name="main" value="0">
                    <input type="checkbox" class="filled-in" id="main-character" name="main" value="1" {{ (old('main') || $character->main) ? 'checked' : '' }}>
                    <label for="main-character">Set as main</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12 right-align">
                    <button type="submit" class="waves-effect waves-light btn-large">
                        Proceed
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop
