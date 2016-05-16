<div class="row post-actions" data-actions>
    <div class="col s12 m12 l12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Post Actions</span>

                <div class="row">
                    <div class="input-field col s12">
                        <select name="action" id="action">
                            @can ('delete', $post)
                                <option value="delete" data-confirm="true" data-method="delete">{{ trans('forum::general.delete') }}</option>
                            @endcan
                        </select>
                        <label>Action</label>
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
