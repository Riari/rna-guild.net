@extends('admin.master')

@section('title', $article->exists ? 'Edit Article' : 'Create Article')

@section('breadcrumbs')
@parent
<a href="{{ url('admin/article') }}" class="breadcrumb">Articles</a>
<span class="breadcrumb">
    @if ($article->exists)
        Edit
    @else
        Create
    @endif
</span>
@append

@section('content')
<div class="row">
    <div class="col m8 offset-m2">
        <form method="POST" action="{{ route($article->exists ? 'admin.article.update' : 'admin.article.store', $article->id) }}">
            {!! csrf_field() !!}
            @if ($article->exists)
                {!! method_field('PATCH') !!}
            @endif

            <div class="row">
                <div class="input-field col s12">
                    <input id="title" name="title" type="text" value="{{ !empty(old('title')) ? old('title') : $article->title }}" autofocus="true">
                    <label for="title">Title</label>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <label for="body">Body</label>
                    <textarea id="body" name="body" class="materialize-textarea">{{ !empty(old('body')) ? old('body') : $article->body }}</textarea>
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
                    <label for="published_at">Publish date & time</label>
                    <input id="published_at" name="published_at" type="text" class="datetimepicker" value="{{ !empty(old('published_at')) ? old('published_at') : $published_at }}">
                    <em class="grey-text">Enter time in UTC.</em>
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
