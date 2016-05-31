<form class="inline" method="post" action="{{ $action }}">
    {!! csrf_field() !!}
    {!! method_field('delete') !!}

    &nbsp; <button type="submit" data-confirm data-text="{{ $text }}" class="btn btn-link">Delete</button>
</form>
