@extends('app')

@section('body_class', 'gallery')

@section('title', $album->exists ? 'Edit image album' : 'Create image album')

@section('content')
<div class="row">
    <div class="col m6 offset-m3">
        <form method="POST" action="{{ route($album->exists ? 'image-album.update' : 'image-album.store', $album->id) }}" enctype="multipart/form-data">
            {!! csrf_field() !!}
            @if ($album->exists)
                {!! method_field('PATCH') !!}
            @endif

            <div class="row">
                <div class="input-field col s12">
                    <input id="title" name="title" type="text" value="{{ !empty(old('title')) ? old('title') : $album->title }}">
                    <label for="title">Title</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <textarea id="description" name="description" class="materialize-textarea">{{ !is_null(old('description')) ? old('description') : $album->description }}</textarea>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <h3>Images</h3>

                    <div class="multi-field-wrapper" data-max="10">
                        <div class="multi-fields">
                            @if ($album->exists)
                                @foreach($album->attachments as $image)
                                    @include('image-album.partials.multi-image-field')
                                @endforeach
                            @else
                                @include('image-album.partials.multi-image-field')
                            @endif
                        </div>
                        <button type="button" class="btn-large blue-grey" data-add>+ Add another</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12 right-align">
                    <button type="submit" class="waves-effect waves-light btn-large">
                        Proceed
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('bottom')
    <style>
    .multi-field-wrapper .multi-field:first-child a[data-remove] {
        display: none;
    }
    </style>
<script>
$('.multi-field-wrapper').each(function () {
    var max = $(this).data('max');
    var wrapper = $('.multi-fields', this);
    var add = $('[data-add]', $(this));
    var remove = $('.multi-field [data-remove]', wrapper);

    add.click(function (e) {
        $('.multi-field:first-child', wrapper).clone(true).appendTo(wrapper);

        if ($('.multi-field', wrapper).length == max) {
            add.hide();
        }
    });

    remove.click(function (e) {
        e.preventDefault();

        if ($('.multi-field', wrapper).length > 1) {
            $(this).parents('.multi-field').remove();
        }

        if ($('.multi-field', wrapper).length < max) {
            add.show();
        }
    });
});
</script>
@stop
