<div id="comments" class="row">
    <div class="col s12">
        @if (!$commentPaginator->isEmpty())
            @foreach ($commentPaginator->items() as $comment)
                @include('comment.partials.row')
            @endforeach
            @include('partials.pagination', ['paginator' => $commentPaginator])
        @else
            <p class="grey-text center-align">
                {{ isset($noComments) ? $noComments : 'No comments yet.' }}
            </p>
        @endif
    </div>
</div>

@foreach ($commentPaginator->items() as $comment)
    @include('partials.delete-modal', ['id' => $comment->id, 'action' => route('comment.delete', compact('comment')), 'text' => "Are you sure you want to delete {$comment->user->name}'s comment?"])
@endforeach
