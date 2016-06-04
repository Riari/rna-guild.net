<div id="actions" class="row category-actions" data-actions>
    <div class="col s12 m12 l12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Category Actions</span>

                <div class="row">
                    <div class="input-field col s12">
                        <select name="action" id="action">
                            @can ('delete', $category)
                                <option value="delete" data-confirm="true" data-method="delete">{{ trans('forum::general.delete') }}</option>
                            @endcan

                            @can ('createCategories')
                                @if ($category->threadsEnabled)
                                    <option value="disable-threads">{{ trans('forum::categories.disable_threads') }}</option>
                                @else
                                    <option value="enable-threads">{{ trans('forum::categories.enable_threads') }}</option>
                                @endif
                                @if ($category->private)
                                    <option value="make-public">{{ trans('forum::categories.make_public') }}</option>
                                @else
                                    <option value="make-private">{{ trans('forum::categories.make_private') }}</option>
                                @endif
                            @endcan
                            @can ('moveCategories')
                                <option value="move">{{ trans('forum::general.move') }}</option>
                                <option value="reorder">{{ trans('forum::general.reorder') }}</option>
                            @endcan
                            @can ('renameCategories')
                                <option value="rename">{{ trans('forum::general.rename') }}</option>
                            @endcan
                        </select>
                        <label>Action</label>
                    </div>
                </div>
                <div class="row hide" data-depends="move">
                    <div class="input-field col s12">
                        <select name="category_id" id="category-id" class="form-control">
                            <option value="0">({{ trans('forum::general.none') }})</option>
                            @include ('forum::category.partials.options', ['hide' => $category])
                        </select>
                        <label for="category-id">{{ trans_choice('forum::categories.category', 1) }}</label>
                    </div>
                </div>
                <div class="row hide" data-depends="reorder">
                    <div class="input-field col s12">
                        <input type="number" name="weight" value="{{ $category->weight }}" class="form-control">
                        <label for="weight">{{ trans('forum::general.weight') }}</label>
                    </div>
                </div>
                <div class="hide" data-depends="rename">
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" id="new-title" name="title" value="{{ $category->title }}" class="form-control">
                            <label for="new-title">{{ trans('forum::general.title') }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" id="new-description" name="description" value="{{ $category->description }}" class="form-control">
                            <label for="new-description">{{ trans('forum::general.description') }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-action right-align">
                <button type="submit" class="waves-effect waves-light btn-large">
                    Proceed
                </button>
            </div>
        </div>
    </div>
</div>
