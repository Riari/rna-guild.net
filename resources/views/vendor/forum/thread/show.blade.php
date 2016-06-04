@extends ('forum::master')

@section('subtitle')
@if ($thread->trashed())
    [{{ trans('forum::general.deleted') }}]
@endif
@if ($thread->locked)
    [{{ trans('forum::threads.locked') }}]
@endif
@if ($thread->pinned)
    [{{ trans('forum::threads.pinned') }}]
@endif
{{ $thread->title }}
@stop

@section ('content')
    <div id="thread">
        @if ($thread->replyCount)
            @can ('deletePosts', $thread)
                <form action="{{ Forum::route('bulk.post.update') }}" method="POST" data-actions-form>
                    {!! csrf_field() !!}
                    {!! method_field('delete') !!}
            @endcan
        @endif

        @can ('reply', $thread)
            <div class="row">
                <div class="col s12 l6">
                    <div class="btn-group" role="group">
                        <a href="{{ Forum::route('post.create', $thread) }}" class="waves-effect waves-light btn-large">{{ trans('forum::general.new_reply') }}</a>
                        <a href="#quick-reply" class="waves-effect waves-light btn-large">{{ trans('forum::general.quick_reply') }}</a>
                    </div>
                </div>
                <div class="col s12 l6 right-align">
                    @include('partials.pagination', ['paginator' => $thread->postsPaginated])
                </div>
            </div>
        @endcan

        <table class="bordered {{ $thread->trashed() ? 'deleted' : '' }}">
            <thead>
                <tr>
                    <th colspan="2" class="right-align">
                        @if ($thread->replyCount)
                            @can ('deletePosts', $thread)
                                <input type="checkbox" id="toggle-all" data-toggle-all>
                                <label for="toggle-all">Select all replies</label>
                            @endcan
                        @endif
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($thread->postsPaginated as $post)
                    @include ('forum::post.partials.list', compact('post'))
                @endforeach
            </tbody>
        </table>

        @if ($thread->replyCount)
            @can ('deletePosts', $thread)
                    @include ('forum::thread.partials.post-actions')
                </form>
            @endcan
        @endif

        @include('partials.pagination', ['paginator' => $thread->postsPaginated])

        @can ('reply', $thread)
            <h3>{{ trans('forum::general.quick_reply') }}</h3>
            <div id="quick-reply">
                <form method="POST" action="{{ Forum::route('post.store', $thread) }}">
                    {!! csrf_field() !!}

                    <div class="row">
                        <div class="col s12">
                            <textarea name="content" class="materialize-textarea">{{ old('content') }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 right-align">
                            <button type="submit" class="waves-effect waves-light btn btn-large">{{ trans('forum::general.reply') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        @endcan
    </div>
@stop

@section('after_content')
@can ('manageThreads', $category)
    <hr>
    <form action="{{ Forum::route('thread.update', $thread) }}" method="POST" data-actions-form>
        {!! csrf_field() !!}
        {!! method_field('patch') !!}

        @include ('forum::thread.partials.actions')
    </form>
@endcan
@stop

@section ('footer')
    <script>
    $('tr input[type=checkbox]').change(function () {
        var postRow = $(this).closest('tr').prev('tr');
        $(this).is(':checked') ? postRow.addClass('active') : postRow.removeClass('active');
    });
    </script>
@stop
