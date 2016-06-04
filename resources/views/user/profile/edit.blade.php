@extends('app')

@section('title', 'Your profile')

@section('content')
<div class="row">
    <div class="col m6 offset-m3">
        <form method="POST" action="{{ url('account/profile/edit') }}" enctype="multipart/form-data">
            {!! csrf_field() !!}

            <div class="row">
                <div class="file-field input-field col s12">
                    <div class="pull-right" style="margin-left:5px;">
                        @include('user.partials.avatar', ['class' => 'small'])
                    </div>
                    <div class="btn">
                        <span>Choose avatar</span>
                        <input type="file" name="avatar">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="family_name" name="family_name" type="text" value="{{ !empty(old('family_name')) ? old('family_name') : $user->profile->family_name }}">
                    <label for="family_name">Family Name</label>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <label for="about">About</label>
                    <textarea id="about" name="about" class="materialize-textarea">{{ !empty(old('about')) ? old('about') : $user->profile->about }}</textarea>
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
