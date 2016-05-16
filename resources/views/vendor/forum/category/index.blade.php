{{-- $category is passed as NULL to the master layout view to prevent it from showing in the breadcrumbs --}}
@extends ('forum::master', ['category' => null])

@section ('content')
    @foreach ($categories as $category)
        <table class="bordered">
            <thead>
                <tr>
                    <th></th>
                    <th class="center-align" style="width:10%;">{{ trans_choice('forum::threads.thread', 2) }}</th>
                    <th class="center-align" style="width:10%;">{{ trans_choice('forum::posts.post', 2) }}</th>
                    <th class="right-align" style="width:15%;">{{ trans('forum::threads.newest') }}</th>
                    <th class="right-align" style="width:15%;">{{ trans('forum::posts.last') }}</th>
                </tr>
            </thead>
            <tbody>
                @include ('forum::category.partials.list', ['class' => 'top'])
                @if (!$category->children->isEmpty())
                    @foreach ($category->children as $subcategory)
                        @include ('forum::category.partials.list', ['category' => $subcategory])
                    @endforeach
                @endif
            </tbody>
        </table>
    @endforeach
@stop
