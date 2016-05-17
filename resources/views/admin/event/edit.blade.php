@extends('admin.master')

@section('title', $event->exists ? 'Edit Event' : 'Create Event')

@section('breadcrumbs')
@parent
<a href="{{ url('admin/event') }}" class="breadcrumb">Events</a>
<span class="breadcrumb">
    @if ($event->exists)
        Edit
    @else
        Create
    @endif
</span>
@append

@section('content')
<div class="row">
    <div class="col m8 offset-m2">
        <form method="POST" action="{{ route($event->exists ? 'admin.event.update' : 'admin.event.store', $event->id) }}">
            {!! csrf_field() !!}
            @if ($event->exists)
                {!! method_field('PATCH') !!}
            @endif

            <div class="row">
                <div class="input-field col s12">
                    <input id="title" name="title" type="text" value="{{ !empty(old('title')) ? old('title') : $event->title }}">
                    <label for="title">Title</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="materialize-textarea">{{ !empty(old('description')) ? old('description') : $event->description }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="location" name="location" type="text" value="{{ !empty(old('location')) ? old('location') : $event->location }}">
                    <label for="location">Location</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="tags" name="tags" type="text" value="{{ !empty(old('tags')) ? old('tags') : $tags }}" data-role="materialtags">
                    <label for="tags">Tags</label>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <input type="hidden" name="all_day" value="0">
                    <input type="checkbox" class="filled-in" id="all-day" name="all_day" {{ (old('all_day') || $event->all_day) ? 'checked' : '' }}>
                    <label for="all-day">All day event</label>
                </div>
            </div>
            <div class="row">
                <div class="col s6">
                    <label for="starts">Starts at</label>
                    <input id="starts" name="starts" type="datetime-local" value="{{ !empty(old('starts')) ? old('starts') : $starts }}">
                </div>
                <div class="col s6">
                    <label for="ends">Ends at</label>
                    <input id="ends" name="ends" type="datetime-local" value="{{ !empty(old('ends')) ? old('ends') : $ends }}">
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <input type="checkbox" class="filled-in" id="public" name="public" {{ (old('public') || $event->public) ? 'checked' : '' }}>
                    <label for="public">Public (visible to guests and new users)</label>
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
@stop
