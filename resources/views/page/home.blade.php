@extends('app')

@section('body_class', 'home')

@section('title', 'Rusty Nails Adventurers')
@section('subtitle', "<em>{$quote}</em>")

@section('content')
<div class="row">
    <div class="col s12 m12 l3">
        <h4>Upcoming events</h4>
        @if ($upcomingEvents->isEmpty())
            <p class="grey-text">No events</p>
        @else
            <ul class="collection">
                @foreach ($upcomingEvents as $event)
                    <li class="collection-item right-align clearfix">
                        <a href="{{ $event->url }}" class="pull-left">
                            {{ $event->title }}
                        </a>
                        @if ($event->starts < \Carbon\Carbon::now())
                            <span class="purple-text">Happening now!</span>
                        @else
                            <span class="grey-text">{{ $event->starts->diffForHumans() }}</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif

        <h4>Newest users</h4>
        <ul class="collection">
            @foreach ($newUsers as $user)
                <li class="collection-item right-align">
                    <a href="{{ $user->profile->url }}" class="pull-left">
                        {{ $user->name }}
                    </a>
                    <span class="grey-text">joined {{ $user->created_at->diffForHumans() }}</span>
                </li>
            @endforeach
        </ul>

        @if (!$onlineUsers->isEmpty())
            <h4>Online users</h4>
            <ul class="collection">
                @foreach ($onlineUsers as $session)
                    <li class="collection-item right-align">
                        <a href="{{ $session->user->profile->url }}" class="pull-left">
                            {{ $session->user->name }}
                        </a>
                        <span class="grey-text">{{ $session->last_activity->diffForHumans() }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="col s12 m12 l6">
        @foreach ($articles as $article)
            @include('article.partials.list')
        @endforeach
        @include('partials.pagination', ['paginator' => $articles])
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
                    <a href="{{ $thread->author->profile->url }}">
                        {{ $thread->author->name }}
                    </a>
                    <br>
                    {{ $thread->created_at->diffForHumans() }}
                </li>
            @endforeach
        </ul>
        <h4>Latest forum replies</h4>
        <ul class="collection">
            @foreach ($newPosts as $post)
                <li class="collection-item grey-text">
                    Re: <a href="{{ Forum::route('thread.show', $post) }}">
                        {{ $post->thread->title }}
                    </a>
                    by
                    <a href="{{ $post->author->profile->url }}">
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
