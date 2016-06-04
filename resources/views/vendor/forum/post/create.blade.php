@extends ('forum::master', ['breadcrumb_other' => trans('forum::general.new_reply')])

@section('title', 'Replying to thread')
@section('subtitle', $thread->title)

@section ('content')
    @if (!is_null($post) && !$post->trashed())
        <h3>{{ trans('forum::general.replying_to', ['item' => $post->authorName]) }}...</h3>

        @include ('forum::post.partials.excerpt')
    @endif

    <form method="POST" action="{{ Forum::route('post.store', $thread) }}">
        {!! csrf_field() !!}
        @if (!is_null($post))
            <input type="hidden" name="post" value="{{ $post->id }}">
        @endif

        <div class="row">
            <div class="col s12">
                <textarea name="content" class="materialize-textarea" data-autofocus="true">{{ old('content') }}</textarea>
            </div>
        </div>

        <button type="submit" class="waves-effect waves-light btn-large pull-right">
            {{ trans('forum::general.reply') }}
        </button>
        <a href="{{ URL::previous() }}" class="waves-effect waves-light btn-large blue-grey lighten-1">
            {{ trans('forum::general.cancel') }}
        </a>
    </form>
@stop
