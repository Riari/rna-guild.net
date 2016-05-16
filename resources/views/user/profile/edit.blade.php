@extends('app')

@section('title', 'Your profile')

@section('content')
<div class="row">
    <div class="col m6 offset-m3">
        <form method="POST" action="{{ url('account/profile/edit') }}">
            {!! csrf_field() !!}

            <div class="row">
                <div class="input-field col s12">
                    <textarea id="about" name="about" class="materialize-textarea">{{ !empty(old('about')) ? old('about') : $user->profile->about }}</textarea>
                    <label for="about">About</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="signature" name="signature" type="text" value="{{ !empty(old('signature')) ? old('signature') : $user->profile->signature }}">
                    <label for="signature">Signature</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12 right-align">
                    <button type="submit" class="waves-effect waves-light btn-large">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
