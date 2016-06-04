{{-- $thread is passed as NULL to the master layout view to prevent it from showing in the breadcrumbs --}}
@extends ('forum::master', ['thread' => null])

@section ('content')
    <div id="category">
        @if (!$category->children->isEmpty())
            <table class="bordered">
                <thead>
                    <tr>
                        <th>{{ trans_choice('forum::categories.category', 1) }}</th>
                        <th class="center-align hide-on-small-only" style="width:10%;">{{ trans_choice('forum::threads.thread', 2) }}</th>
                        <th class="center-align hide-on-small-only" style="width:10%;">{{ trans_choice('forum::posts.post', 2) }}</th>
                        <th class="right-align hide-on-small-only" style="width:20%;">{{ trans('forum::threads.newest') }}</th>
                        <th class="right-align" style="width:20%;">{{ trans('forum::posts.last') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($category->children as $subcategory)
                        @include ('forum::category.partials.list', ['category' => $subcategory])
                    @endforeach
                </tbody>
            </table>
        @endif

        <div class="row">
            <div class="col s4">
                @if ($category->threadsEnabled)
                    @can ('createThreads', $category)
                        <a href="{{ Forum::route('thread.create', $category) }}" class="waves-effect waves-light btn-large">{{ trans('forum::threads.new_thread') }}</a>
                    @endcan
                @endif
            </div>
            <div class="col s8 right-align">
                @include('partials.pagination', ['paginator' => $category->threadsPaginated])
            </div>
        </div>

        @if (!$category->threadsPaginated->isEmpty())
            @can ('manageThreads', $category)
                <form action="{{ Forum::route('bulk.thread.update') }}" method="POST" data-actions-form>
                    {!! csrf_field() !!}
                    {!! method_field('delete') !!}
            @endcan
        @endif

        @if ($category->threadsEnabled)
            <table id="threads" class="bordered">
                <thead>
                    <tr>
                        <th>{{ trans('forum::general.subject') }}</th>
                        <th class="col-md-2 right-align hide-on-small-only">{{ trans('forum::general.replies') }}</th>
                        <th class="col-md-2 right-align">{{ trans('forum::posts.last') }}</th>
                        @can ('manageThreads', $category)
                            <th class="col-md-1 right-align"><input type="checkbox" data-toggle-all></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @if (!$category->threadsPaginated->isEmpty())
                        @foreach ($category->threadsPaginated as $thread)
                            <tr class="{{ $thread->trashed() ? "deleted" : "" }}">
                                <td>
                                    <span class="pull-right">
                                        @if ($thread->locked)
                                            <span class="label label-warning">{{ trans('forum::threads.locked') }}</span>
                                        @endif
                                        @if ($thread->pinned)
                                            <span class="label label-info">{{ trans('forum::threads.pinned') }}</span>
                                        @endif
                                        @if ($thread->userReadStatus && !$thread->trashed())
                                            <span class="label label-primary">{{ trans($thread->userReadStatus) }}</span>
                                        @endif
                                        @if ($thread->trashed())
                                            <span class="label label-danger">{{ trans('forum::general.deleted') }}</span>
                                        @endif
                                    </span>
                                    <a href="{{ Forum::route('thread.show', $thread) }}">
                                        <strong>{{ $thread->title }}</strong>
                                    </a>
                                    <br>
                                    <p>
                                        <a href="{{ $thread->author->profile->url }}">
                                            {{ $thread->authorName }}
                                        </a>
                                        <span class="grey-text">({{ $thread->posted }})</span>
                                    </p>
                                </td>
                                @if ($thread->trashed())
                                    <td colspan="2">&nbsp;</td>
                                @else
                                    <td class="right-align hide-on-small-only">
                                        {{ $thread->replyCount }}
                                    </td>
                                    <td class="right-align">
                                        <a href="{{ $thread->lastPost->author->profile->url }}">
                                            <strong>{{ $thread->lastPost->authorName }}</strong>
                                        </a>
                                        <br>
                                        <span class="grey-text">({{ $thread->lastPost->posted }})</span>
                                        <br>
                                        <a href="{{ Forum::route('thread.show', $thread->lastPost) }}">{{ trans('forum::posts.view') }}</a>
                                    </td>
                                @endif
                                @can ('manageThreads', $category)
                                    <td class="right-align">
                                        <input type="checkbox" name="items[]" id="select-thread-{{ $thread->id }}" value="{{ $thread->id }}">
                                        <label for="select-thread-{{ $thread->id }}"></label>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>
                                {{ trans('forum::threads.none_found') }}
                            </td>
                            <td class="right-align" colspan="3">
                                @can ('createThreads', $category)
                                    <a href="{{ Forum::route('thread.create', $category) }}">{{ trans('forum::threads.post_the_first') }}</a>
                                @endcan
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        @endif

        @if (!$category->threadsPaginated->isEmpty())
            @can ('manageThreads', $category)
                    @include ('forum::category.partials.thread-actions')
                </form>
            @endcan
        @endif

        <div class="row">
            <div class="col s4">
                @if ($category->threadsEnabled)
                    @can ('createThreads', $category)
                        <a href="{{ Forum::route('thread.create', $category) }}" class="waves-effect waves-light btn-large">{{ trans('forum::threads.new_thread') }}</a>
                    @endcan
                @endif
            </div>
            <div class="col s8 right-align">
                @include('partials.pagination', ['paginator' => $category->threadsPaginated])
            </div>
        </div>

        @if ($category->threadsEnabled)
            @can ('markNewThreadsAsRead')
                <hr>
                <div class="row">
                    <div class="col s12 center-align">
                        <form action="{{ Forum::route('mark-new') }}" method="POST" data-confirm>
                            {!! csrf_field() !!}
                            {!! method_field('patch') !!}
                            <input type="hidden" name="category_id" value="{{ $category->id }}">
                            <button class="waves-effect waves-light btn btn-large blue-grey lighten-1">
                                {{ trans('forum::categories.mark_read') }}
                            </button>
                        </form>
                    </div>
                </div>
            @endcan
        @endif
    </div>
@stop

@section('after_content')
@can ('manageCategories')
    <hr>
    <form action="{{ Forum::route('category.update', $category) }}" method="POST" data-actions-form>
        {!! csrf_field() !!}
        {!! method_field('patch') !!}

        @include ('forum::category.partials.actions')
    </form>
@endcan
@stop
