{{-- $category is passed as NULL to the master layout view to prevent it from showing in the breadcrumbs --}}
@extends ('forum::master', ['category' => null])

@section ('content')
<div id="index">
    @foreach ($categories as $category)
        <table class="bordered">
            <thead>
                <th>
                    <a href="{{ Forum::route('category.show', $category) }}" class="title">
                        {{ $category->title }}
                    </a>
                    <br>
                    {{ $category->description }}
                </th>
                <th class="center-align hide-on-small-only" style="width:10%;">{{ trans_choice('forum::threads.thread', 2) }}</th>
                <th class="center-align hide-on-small-only" style="width:10%;">{{ trans_choice('forum::posts.post', 2) }}</th>
                <th class="right-align hide-on-small-only" style="width:20%;">{{ trans('forum::threads.newest') }}</th>
                <th class="right-align" style="width:20%;">{{ trans('forum::posts.last') }}</th>
            </thead>
            <tbody>
                @if (!$category->children->isEmpty())
                    @foreach ($category->children as $subcategory)
                        @include ('forum::category.partials.list', ['category' => $subcategory])
                    @endforeach
                @endif
            </tbody>
        </table>
    @endforeach
</div>
@stop
