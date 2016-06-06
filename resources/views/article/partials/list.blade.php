<div class="article">
    <h3><a href="{{ $article->url }}">{{ $article->title }}</a></h3>
    <span class="grey-text">
        <a href="{{ $article->url }}#comments" class="pull-right">
            {{ $article->comments()->count() }}
            {{ str_plural('comment', $article->comments()->count()) }}
        </a>
        Published by
        <a href="{{ $article->user->profile->url }}">
            {{ $article->user->name }}
        </a>
        {{ $article->publishedAgo }}
    </span>
    {!! Markdown::convertToHtml($article->body) !!}
    @include('partials.tag-list', ['model' => $article])
    <hr>
</div>
