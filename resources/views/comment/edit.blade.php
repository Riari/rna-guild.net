@extends('app')

@section('title', 'Edit comment')
@section('subtitle', "on {$comment->commentable->friendlyName}")

@section('content')
<div class="row">
    <div class="col m6 offset-m3">
        <form method="post" action="{{ route('comment.update', compact('comment')) }}">
            {!! csrf_field() !!}
            {!! method_field('patch') !!}

            <div class="row">
                <div class="col s12">
                    <textarea id="body" name="body" class="materialize-textarea" data-autofocus="true">{{ !is_null(old('body')) ? old('body') : $comment->body }}</textarea>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12 right-align">
                    <input type="hidden" name="redirect_to" value="{{ URL::previous() }}#comments">
                    <button type="submit" class="waves-effect waves-light btn-large">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
