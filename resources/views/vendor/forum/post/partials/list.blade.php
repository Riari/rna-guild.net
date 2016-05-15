<tr id="post-{{ $post->id }}" class="post {{ $post->trashed() ? 'deleted' : '' }}">
    <td>
        <a href="{{ $post->author->profileUrl }}" class="author-name">{!! $post->authorName !!}</a><br>
        @include ('user.partials.rank-list', ['user' => $post->author])
    </td>
    <td class="body">
        @if (!is_null($post->parent))
            <p>
                <strong>
                    {{ trans('forum::general.response_to', ['item' => $post->parent->authorName]) }}
                    (<a href="{{ Forum::route('post.show', $post->parent) }}">{{ trans('forum::posts.view') }}</a>):
                </strong>
            </p>
            <blockquote>
                {!! str_limit(Forum::render($post->parent->content)) !!}
            </blockquote>
        @endif

        @if ($post->trashed())
            <span class="label label-danger">{{ trans('forum::general.deleted') }}</span>
        @else
            {!! Markdown::convertToHtml($post->content) !!}
        @endif
    </td>
</tr>
<tr>
    <td>
        @if (!$post->trashed())
            @can ('edit', $post)
                <a href="{{ Forum::route('post.edit', $post) }}">{{ trans('forum::general.edit') }}</a>
            @endcan
        @endif
    </td>
    <td class="text-muted">
        {{ trans('forum::general.posted') }} {{ $post->posted }}
        @if ($post->hasBeenUpdated())
            | {{ trans('forum::general.last_updated') }} {{ $post->updated }}
        @endif
        <span class="pull-right">
            <a href="{{ Forum::route('thread.show', $post) }}">#{{ $post->id }}</a>
            @if (!$post->trashed())
                @can ('reply', $post->thread)
                    - <a href="{{ Forum::route('post.create', $post) }}">{{ trans('forum::general.reply') }}</a>
                @endcan
            @endif
            @if (Request::fullUrl() != Forum::route('post.show', $post))
                - <a href="{{ Forum::route('post.show', $post) }}">{{ trans('forum::posts.view') }}</a>
            @endif
            @if (isset($thread))
                @can ('deletePosts', $thread)
                    @if (!$post->isFirst)
                        <input type="checkbox" name="items[]" id="select-post-{{ $post->id }}" value="{{ $post->id }}">
                        <label for="select-post-{{ $post->id }}"></label>
                    @endif
                @endcan
            @endif
        </span>
    </td>
</tr>
