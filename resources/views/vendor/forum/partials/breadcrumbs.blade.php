<a href="{{ url(config('forum.routing.root')) }}" class="breadcrumb">Forum</a>
@if (isset($category) && $category)
    @include ('forum::partials.breadcrumb-categories', ['category' => $category])
@endif
@if (isset($thread) && $thread)
    <a href="{{ Forum::route('thread.show', $thread) }}" class="breadcrumb">{{ $thread->title }}</a>
@endif
@if (isset($breadcrumb_other) && $breadcrumb_other)
    <span class="breadcrumb">{!! $breadcrumb_other !!}</span>
@endif
