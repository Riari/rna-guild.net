<div class="multi-field">
    <div class="file-field">
        <div class="btn">
            <span>File</span>
            <input type="file" name="images[]">
        </div>
        <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
        </div>
    </div>
    @if (isset($image))
        Current: {{ $image->getUrl() }}
    @endif
    <div class="input-field">
        <input id="title" name="image_captions[]" type="text" value="{{ isset($image) ? $image->title : '' }}">
        <label for="title">Caption</label>
    </div>
    <p class="right-align">
        <a href="#" data-remove>Remove</a>
    </p>
</div>
