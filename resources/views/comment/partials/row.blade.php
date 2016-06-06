<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                {!! Markdown::convertToHtml($comment->body) !!}
            </div>
            <div class="card-footer grey-text">
                <div class="pull-right">
                    @can ('edit', $comment)
                        <a href="{{ route('comment.edit', compact('comment')) }}">Edit</a>
                    @endcan
                    @can ('delete', $comment)
                        @include('partials.delete-link', ['id' => $comment->id])
                    @endcan
                </div>
                <a href="{{ $comment->user->profile->url }}">
                    @include('user.partials.avatar', ['user' => $comment->user, 'class' => 'tiny circular'])
                    {{ $comment->user->name }}
                </a>
                {{ $comment->createdAgo }}
                @if ($comment->created_at != $comment->updated_at)
                    (edited {{ $comment->updatedAgo }})
                @endif
            </div>
        </div>
    </div>
</div>
