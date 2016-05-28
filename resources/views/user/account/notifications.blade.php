@extends('app')

@section('title', 'Notifications')

@section('content')
<div class="row">
    <div class="col s12 m12 l8 offset-l2">
        <div class="collection" style="margin:0;">
            @foreach ($notifications as $notification)
                <a href="{{ $notification->url }}" class="collection-item">
                    {{ $notification->text }}
                    <span class="grey-text">{{ $notification->created_at->diffForHumans() }}</span>
                    @if (!$notification->read)
                        <span class="deep-orange accent-4 new badge"></span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>
@stop
