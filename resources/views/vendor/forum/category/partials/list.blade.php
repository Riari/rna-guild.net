<tr class="category {{ isset($class) ? $class : '' }}">
    <td {{ $category->threadsEnabled ? '' : 'colspan=5'}}>
        <a href="{{ Forum::route('category.show', $category) }}" class="title">
            {{ $category->title }}
        </a>
        <br>
        <span class="text-muted">{{ $category->description }}</span>
    </td>
    @if ($category->threadsEnabled)
        <td class="center-align">{{ $category->threadCount }}</td>
        <td class="center-align">{{ $category->postCount }}</td>
        <td class="right-align">
            @if ($category->newestThread)
                <a href="{{ Forum::route('thread.show', $category->newestThread) }}">
                    {{ $category->newestThread->title }}
                    ({{ $category->newestThread->authorName }})
                </a>
            @endif
        </td>
        <td class="right-align">
            @if ($category->latestActiveThread)
                <a href="{{ Forum::route('thread.show', $category->latestActiveThread->lastPost) }}">
                    {{ $category->latestActiveThread->title }}
                    ({{ $category->latestActiveThread->lastPost->authorName }})
                </a>
            @endif
        </td>
    @endif
</tr>
