<p class="center-align">
    <a class="waves-effect waves-light btn btn-large modal-trigger" href="#add-comment">Add comment</a>
</p>

<div id="add-comment" class="modal bottom-sheet">
    <div class="modal-content">
        <h4 class="center-align">Add a comment</h4>

        <div class="row">
            <div class="col s12 m8 l8 offset-m2 offset-l2">
                <form method="POST" action="{{ route('comment.store', compact('model', 'id')) }}">
                    {!! csrf_field() !!}

                    <div class="row">
                        <div class="col s12">
                            <textarea id="body" name="body" class="materialize-textarea">{{ old('body') }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 right-align">
                            <input type="hidden" name="redirect_to" value="{{ Request::url() }}#comments">
                            <a href="#!" class="modal-action modal-close waves-effect waves-light btn-large btn-flat">Cancel</a>
                            <button type="submit" class="waves-effect waves-light btn-large">
                                Add
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
