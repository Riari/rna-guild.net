@if (!is_null($category->parent))
    @include ('forum::partials.breadcrumb-categories', ['category' => $category->parent])
@endif
<a href="{{ Forum::route('category.show', $category) }}" class="breadcrumb">{{ $category->title }}</a>
