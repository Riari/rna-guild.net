@extends('admin.master')

@section('title', 'Create Forum Category')

@section('breadcrumbs')
@parent
<span class="breadcrumb">Forum</span>
<a href="{{ url('admin/forum/category') }}" class="breadcrumb">Categories</a>
<span class="breadcrumb">Create</span>
@append

@section('content')
<form method="post" action="{{ Forum::route('category.store') }}">
    {!! csrf_field() !!}

    <div class="row">
        <div class="input-field col s12 m6">
            <input type="text" name="title" value="{{ old('title') }}" autofocus="true">
            <label for="title">Title</label>
        </div>
        <div class="input-field col s12 m6">
            <input type="text" name="description" value="{{ old('description') }}">
            <label for="description">Description</label>
        </div>
        <div class="input-field col s12 m6">
            <select name="category_id" id="category-id">
                <option value="0">(None)</option>
                @include ('forum::category.partials.options')
            </select>
            <label for="category-id">Parent Category</label>
        </div>
        <div class="input-field col s12 m6">
            <input type="number" id="weight" name="weight" value="{{ !empty(old('weight')) ? old('weight') : 0 }}">
            <label for="weight">Weight</label>
            <span class="grey-text">A higher value will make the category display further down the list.</span>
        </div>
        <div class="input-field col s12 m6">
            <input type="hidden" name="enable_threads" value="0">
            <input type="checkbox" class="filled-in" id="enable_threads" name="enable_threads" value="1" {{ old('enable_threads') ? 'checked' : '' }}>
            <label for="enable_threads">Enable threads</label>
        </div>
        <div class="input-field col s12 m6">
            <input type="hidden" name="private" value="0">
            <input type="checkbox" class="filled-in" id="private" name="private" value="1" {{ old('private') ? 'checked' : '' }}>
            <label for="private">Private (visible only to approved users)</label>
        </div>
    </div>

    <div class="right-align">
        <button type="submit" class="waves-effect waves-light btn-large">Save</button>
    </div>
</form>
@stop
