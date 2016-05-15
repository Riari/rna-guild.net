<div class="row thread-actions" data-actions>
    <div class="col s12 m12 l12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Thread Actions</span>

                <div class="row">
                    <div class="input-field col s12">
                        <select name="action" id="action">
                            @can ('deleteThreads', $category)
                                @if ($thread->trashed())
                                    <option value="restore" data-confirm="true">{{ trans('forum::general.restore') }}</option>
                                @else
                                    <option value="delete" data-confirm="true" data-method="delete">{{ trans('forum::general.delete') }}</option>
                                @endif
                                <option value="permadelete" data-confirm="true" data-method="delete">{{ trans('forum::general.perma_delete') }}</option>
                            @endcan

                            @if (!$thread->trashed())
                                @can ('moveThreadsFrom', $category)
                                    <option value="move">{{ trans('forum::general.move') }}</option>
                                @endcan
                                @can ('lockThreads', $category)
                                    @if ($thread->locked)
                                        <option value="unlock">{{ trans('forum::threads.unlock') }}</option>
                                    @else
                                        <option value="lock">{{ trans('forum::threads.lock') }}</option>
                                    @endif
                                @endcan
                                @can ('pinThreads', $category)
                                    @if ($thread->pinned)
                                        <option value="unpin">{{ trans('forum::threads.unpin') }}</option>
                                    @else
                                        <option value="pin">{{ trans('forum::threads.pin') }}</option>
                                    @endif
                                @endcan
                                @can ('rename', $thread)
                                    <option value="rename">{{ trans('forum::general.rename') }}</option>
                                @endcan
                            @endif
                        </select>
                        <label>Action</label>
                    </div>
                </div>
                <div class="row hide" data-depends="move">
                    <div class="input-field col s12">
                        <select name="category_id" id="category-id">
                            @include ('forum::category.partials.options', ['hide' => $thread->category])
                        </select>
                        <label for="category-id">{{ trans_choice('forum::categories.category', 1) }}</label>
                    </div>
                </div>
                <div class="row hide" data-depends="rename">
                    <div class="input-field col s12">
                        <input id="new-title" type="text" name="title" value="{{ $thread->title }}" class="form-control">
                        <label for="new-title">{{ trans('forum::general.title') }}</label>
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
