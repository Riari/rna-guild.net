@extends('app')

@section('body_class', 'home')

@section('title', 'Rusty Nails Adventurers')
@section('subtitle', "<em>{$quote}</em>")

@section('content')
<div class="row">
    <div class="col s12 m12 l3">
        <h4>Newest users</h4>
        <ul class="collection">
            @foreach ($newUsers as $user)
                <li class="collection-item right-align">
                    <a href="{{ $user->profileUrl }}" class="pull-left">
                        {{ $user->name }}
                    </a>
                    <span class="grey-text">joined {{ $user->created_at->diffForHumans() }}</span>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="col s12 m12 l6">
        @foreach ($articles as $article)
            <div class="article">
                <h3>{{ $article->title }}</h3>
                <span class="grey-text">
                    Published by
                    <a href="{{ $article->author->profileUrl }}">
                        {{ $article->author->name }}
                    </a>
                    {{ $article->published_at->diffForHumans() }}
                </span>
                {!! Markdown::convertToHtml($article->body) !!}
                @foreach ($article->tagNames() as $tag)
                    <div class="chip">{{ $tag }}</div>
                @endforeach
                <hr>
            </div>
        @endforeach
        {!! $articles->render() !!}
    </div>
    <div class="col s12 m12 l3">
        <h4>Latest forum threads</h4>
        <ul class="collection">
            @foreach ($newThreads as $thread)
                <li class="collection-item grey-text">
                    <a href="{{ Forum::route('thread.show', $thread) }}">
                        {{ $thread->title }}
                    </a>
                    by
                    <a href="{{ $thread->author->profileUrl }}">
                        {{ $thread->author->name }}
                    </a>
                    <br>
                    {{ $thread->created_at->diffForHumans() }}
                </li>
            @endforeach
        </ul>
        <hr>
        <h4>Latest forum posts</h4>
        <ul class="collection">
            @foreach ($newPosts as $post)
                <li class="collection-item grey-text">
                    Re: <a href="{{ Forum::route('thread.show', $post) }}">
                        {{ $post->thread->title }}
                    </a>
                    by
                    <a href="{{ $post->author->profileUrl }}">
                        {{ $post->author->name }}
                    </a>
                    <br>
                    {{ $post->created_at->diffForHumans() }}
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
