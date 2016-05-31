<tr id="post-{{ $post->sequenceNumber }}" class="post {{ $post->trashed() ? 'deleted' : '' }}">
    <td class="author-info center-align hide-on-small-only">
        <p class="center-align">
            <a href="{{ $post->author->profile->url }}" class="author-name">
                {!! $post->author->displayName !!}
            </a>
            <a href="{{ $post->author->profile->url }}">
                @include('user.partials.avatar', ['user' => $post->author, 'class' => 'circular'])
            </a>
        </p>
        @include ('user.partials.role-list', ['user' => $post->author])
        @if (!is_null($post->author->mainCharacter))
            <p class="grey-text center-align">
                Main character:
                <br>
                <a href="{{ $post->author->mainCharacter->url }}">{{ $post->author->mainCharacter->name }}</a>
            </p>
        @endif
    </td>
    <td class="body {{ !empty($post->author->profile->signature) ? 'with-signature' : '' }}">
        <span class="grey-text hide-on-med-and-up">
            {{ $post->posted }}
            <a href="{{ $post->author->profile->url }}" class="author-name">
                <strong>
                    @include('user.partials.avatar', ['user' => $post->author, 'class' => 'tiny circular'])
                    {!! $post->author->displayName !!}
                </strong>
            </a>
            said…
        </span>
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

            @if ($post->hasBeenUpdated())
                <p class="grey-text hide-on-med-and-up">
                    <em>Edited {{ $post->updated }}</em>
                </p>
            @endif

            @if (!empty($post->author->profile->signature))
                <blockquote class="signature">
                    {{ $post->author->profile->signature }}
                </blockquote>
            @endif
        @endif
    </td>
</tr>
<tr>
    <td class="hide-on-small-only">
        @if (!$post->trashed())
            @can ('edit', $post)
                <a href="{{ Forum::route('post.edit', $post) }}">{{ trans('forum::general.edit') }}</a>
            @endcan
        @endif
    </td>
    <td class="grey-text">
        <span class="hide-on-small-only">
            {{ trans('forum::general.posted') }} {{ $post->posted }}@if ($post->hasBeenUpdated()), updated {{ $post->updated }}@endif
        </span>
        <span class="hide-on-med-and-up">
            @if (!$post->trashed())
                @can ('edit', $post)
                    <a href="{{ Forum::route('post.edit', $post) }}">{{ trans('forum::general.edit') }}</a>
                @endcan
            @endif
        </span>
        <span class="pull-right">
            <a href="{{ Forum::route('thread.show', $post) }}">#{{ $post->sequenceNumber }}</a>
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
