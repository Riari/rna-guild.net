<div class="article">
    <h3>{{ $article->title }}</h3>
    <span class="grey-text">
        Published by
        <a href="{{ $article->author->profile->url }}">
            {{ $article->author->name }}
        </a>
        {{ $article->published_at->diffForHumans() }}
    </span>
    {!! Markdown::convertToHtml($article->body) !!}
    @include('partials.tag-list', ['model' => $article])
    <hr>
</div>
