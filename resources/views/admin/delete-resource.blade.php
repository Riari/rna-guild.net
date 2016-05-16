@extends('admin.master')

@section('title', "Delete {$model}")

@section('content')
<div class="row">
    <div class="col m6 offset-m3">
        <form method="POST" action="{{ url("admin/{$model}/{$id}") }}">
            {!! csrf_field() !!}
            {!! method_field('DELETE') !!}

            <p>Delete {{ $model }} #{{ $id }}?</p>

            <div class="row">
                <div class="input-field col s12 right-align">
                    <button type="submit" class="waves-effect waves-light btn-large red">
                        Yes please
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
