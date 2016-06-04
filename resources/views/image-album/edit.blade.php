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
                    <input id="title" name="title" type="text" value="{{ !empty(old('title')) ? old('title') : $album->title }}" autofocus="true">
                    <label for="title">Title</label>
                    <span class="red-text">Required</span>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <label>Description</label>
                    <textarea id="description" name="description" class="materialize-textarea">{{ !is_null(old('description')) ? old('description') : $album->description }}</textarea>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <h3>Images</h3>

                    <p>You can add up to <strong>10</strong> images.</p>

                    <div class="multi-field-wrapper" data-max="10">
                        <div class="multi-fields">
                            @if ($album->exists)
                                @foreach($album->attachments()->orderBy('key')->get() as $image)
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
        <div class="multi-field-template hide">
            @include('image-album.partials.multi-image-field', ['image' => null, 'remove' => false])
        </div>
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

    add.click(function (e) {
        // Append a new field to the list
        var field = $('.multi-field-template .multi-field').clone(true).appendTo(wrapper);

        // Enumerate the fields
        enumerate();

        // If we've hit the specified field limit, make sure the add button is
        // hidden
        if ($('.multi-field', wrapper).length == max) {
            add.hide();
        }
    });

    wrapper.on('click', '[data-remove]', function (e) {
        e.preventDefault();

        // If this isn't the only field in the list, remove it
        if ($('.multi-field', wrapper).length > 1) {
            $(this).parents('.multi-field').remove();
        }

        // Enumerate the fields
        enumerate();

        // If we're now below the specified maximum, make sure the add button is
        // shown
        if ($('.multi-field', wrapper).length < max) {
            add.show();
        }
    });

    function enumerate() {
        var fields = $('.multi-fields .multi-field');
        var index = fields.first().attr('data-index');

        fields.each(function (idx, field) {
            $(field).find('[data-file-input]').attr('name', 'image_files[' + index + ']');
            $(field).find('[data-caption-input]').attr('name', 'image_captions[' + index + ']');
            index++;
        });
    }
});
</script>
@stop
