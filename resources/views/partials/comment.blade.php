<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                {!! Markdown::convertToHtml($comment->body) !!}
            </div>
            <div class="card-footer grey-text">
                by <a href="{{ $comment->author->profileUrl }}">{{ $comment->author->name }}</a> {{ $comment->created_at->diffForHumans() }}
            </div>
        </div>
    </div>
</div>
