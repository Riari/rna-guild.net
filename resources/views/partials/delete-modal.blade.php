<div id="delete-item-{{ $id }}" class="modal">
    <div class="modal-content center-align">
        <h4>Are you sure?</h4>
        <i class="large material-icons orange-text">error_outline</i>
        <p>{{ $text }}</p>
    </div>
    <div class="modal-footer">
        <form method="post" action="{{ $action }}">
            {!! csrf_field() !!}
            {!! method_field('delete') !!}

            <button type="submit" class="waves-effect waves-light btn-flat">Yes please</button>
            <a href="#!" class="modal-action modal-close waves-effect waves-light btn btn-flat">Cancel</a>
        </form>
    </div>
</div>
