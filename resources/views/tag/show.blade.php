@extends('app')

@section('title', 'Viewing content by tag')
@section('subtitle', $tag)

@section('content')
<div class="row">
    <div class="col s12">
        <ul class="tabs">
            <li class="tab col s3"><a class="active" href="#articles">Articles</a></li>
            <li class="tab col s3"><a href="#events">Events</a></li>
        </ul>
    </div>
    <div id="articles" class="tab-content col s12">
        @if ($articles->isEmpty())
            <p class="grey-text center-align">No articles tagged <em>{{ $tag }}</em></p>
        @else
            @foreach ($articles as $article)
                @include('article.partials.list')
            @endforeach
        @endif
    </div>
    <div id="events" class="tab-content col s12">
        @if ($events->isEmpty())
            <p class="grey-text center-align">No events tagged <em>{{ $tag }}</em></p>
        @else
            {!! $calendar->calendar() !!}
        @endif
    </div>
</div>
@stop

@if (!$events->isEmpty())
    @section('bottom')
    {!! $calendar->script() !!}
    <script>
    $('ul.tabs a[href="#events"]').click(function () {
        setTimeout(function () {
            $('#events > div').fullCalendar('render');
        }, 1);
    });
    </script>
    @stop
@endif
