@foreach ($model->tags as $tag)
    <div class="chip">
        <a href="{{ url("tagged/{$tag->slug}") }}">{{ $tag->name }}</a>
    </div>
@endforeach
