<li data-id="{{ $category->id }}">
    <input type="hidden" name="categories[{{ $category->id }}]" value="{{ $category->parent_id }}" data-sorting>
    <span class="pull-right">
        <span class="grey-text text-darken-1">{{ $category->threads->count() }} {{ str_plural('thread', $category->threads->count() )}}</span>
        &nbsp; <a href="{{ Forum::route('category.show', $category) }}#actions">Edit</a>
        @if ($category->children->isEmpty() && $category->threads->isEmpty())
            @include('partials.delete-link', ['id' => $category->id])
        @endif
    </span>
    <a href="{{ Forum::route('category.show', $category) }}">{{ $category->title }}</a><br>
    <span class="grey-text text-darken-1">{{ $category->description }}</span>
    <ol>
        @if ($category->children)
            @foreach ($category->children as $category)
                @include('admin.forum.category.partials.row')
            @endforeach
        @endif
    </ol>
</li>
