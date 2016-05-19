<table class="bordered">
    <thead>
        <tr>
            <th>
                {{ trans('forum::general.author') }}
            </th>
            <th>
                {{ trans_choice('forum::posts.post', 1) }}
            </th>
        </tr>
    </thead>
    <tbody>
        <tr id="post-{{ $post->id }}" class="post">
            <td class="author-info">
                <a href="{{ $post->author->profile->url }}">
                    <strong>{!! $post->authorName !!}</strong>
                </a>
            </td>
            <td class="body">
                {!! Markdown::convertToHtml($post->content) !!}
            </td>
        </tr>
    </tbody>
</table>
