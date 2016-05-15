@extends ('forum::master', ['breadcrumb_other' => trans('forum::threads.new_thread')])

@section('title', 'Create new thread')
@section('subtitle', "Category: {$category->title}")

@section ('content')
    <form method="POST" action="{{ Forum::route('thread.store', $category) }}">
        {!! csrf_field() !!}
        {!! method_field('post') !!}

        <div class="row">
            <div class="input-field col s12">
                <input type="text" name="title" value="{{ old('title') }}">
                <label for="title">{{ trans('forum::general.title') }}</label>
            </div>
        </div>

        <textarea name="content">{{ old('content') }}</textarea>

        <button type="submit" class="btn-large pull-right">{{ trans('forum::general.create') }}</button>
        <a href="{{ URL::previous() }}" class="btn-large blue-grey lighten-1">{{ trans('forum::general.cancel') }}</a>
    </form>
@stop
