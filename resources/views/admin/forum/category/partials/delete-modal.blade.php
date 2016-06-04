@include('admin.partials.delete-modal', ['id' => $category->id, 'model' => 'Forum\Category', 'model_id' => $category->id, 'text' => "Are you sure you want to delete category {$category->title}?"])

@if ($category->children)
    @foreach ($category->children as $category)
        @include('admin.forum.category.partials.delete-modal')
    @endforeach
@endif
