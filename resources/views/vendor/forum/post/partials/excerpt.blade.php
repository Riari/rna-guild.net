<table class="bordered">
    <thead>
        <tr>
            <th style="width:20%">
                {{ trans('forum::general.author') }}
            </th>
            <th>
                {{ trans_choice('forum::posts.post', 1) }}
            </th>
        </tr>
    </thead>
    <tbody>
        <tr id="post-{{ $post->id }}">
            <td>
                <a href="{{ $post->author->profileUrl }}">
                    <strong>{!! $post->authorName !!}</strong>
                </a>
            </td>
            <td>
                {!! Markdown::convertToHtml($post->content) !!}
            </td>
        </tr>
    </tbody>
</table>
