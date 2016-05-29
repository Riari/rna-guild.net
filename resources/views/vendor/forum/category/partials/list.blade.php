<tr class="category {{ isset($class) ? $class : '' }}">
    <td {{ $category->threadsEnabled ? '' : 'colspan=5'}}>
        <a href="{{ Forum::route('category.show', $category) }}" class="title">
            {{ $category->title }}
        </a>
        <br>
        <span class="grey-text darken-1">{{ $category->description }}</span>
    </td>
    @if ($category->threadsEnabled)
        <td class="center-align hide-on-small-only">{{ $category->threadCount }}</td>
        <td class="center-align hide-on-small-only">{{ $category->postCount }}</td>
        <td class="right-align hide-on-small-only">
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
