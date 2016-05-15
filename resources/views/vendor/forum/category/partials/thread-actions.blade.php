<div class="row" data-actions data-bulk-actions>
    <div class="col s12 m12 l12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">With selection...</span>

                <div class="row">
                    <div class="input-field col s12">
                        <select name="action" id="action">
                            @can ('deleteThreads', $category)
                                <option value="delete" data-confirm="true" data-method="delete">{{ trans('forum::general.delete') }}</option>
                                <option value="restore" data-confirm="true">{{ trans('forum::general.restore') }}</option>
                                <option value="permadelete" data-confirm="true" data-method="delete">{{ trans('forum::general.perma_delete') }}</option>
                            @endcan
                            @can ('moveThreadsFrom', $category)
                                <option value="move">{{ trans('forum::general.move') }}</option>
                            @endcan
                            @can ('lockThreads', $category)
                                <option value="lock">{{ trans('forum::threads.lock') }}</option>
                                <option value="unlock">{{ trans('forum::threads.unlock') }}</option>
                            @endcan
                            @can ('pinThreads', $category)
                                <option value="pin">{{ trans('forum::threads.pin') }}</option>
                                <option value="unpin">{{ trans('forum::threads.unpin') }}</option>
                            @endcan
                        </select>
                        <label>Action</label>
                    </div>
                </div>
                <div class="row hide" data-depends="move">
                    <div class="input-field col s12">
                        <label for="category-id">{{ trans_choice('forum::categories.category', 1) }}</label>
                        <select name="category_id" id="category-id" class="form-control">
                            @include ('forum::category.partials.options', ['hide' => $category])
                        </select>
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
