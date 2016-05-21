<div class="multi-field" data-index="{{ isset($image) ? $image->key : '0' }}">
    <div class="file-field">
        <div class="btn">
            <span>File</span>
            <input type="file" data-file-input name="image_files[{{ isset($image) ? $image->key : '' }}]">
        </div>
        <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
        </div>
    </div>
    @if (isset($image))
        Current: <a href="{{ $image->getUrl() }}">{{ $image->getUrl() }}</a>
    @endif
    <div class="input-field">
        <input id="title" data-caption-input name="image_captions[{{ isset($image) ? $image->key : '' }}]" type="text" value="{{ isset($image) ? $image->title : '' }}">
        <label for="title">Caption</label>
    </div>
    <p class="right-align">
        <a href="#" data-remove>Remove</a>
    </p>
</div>
