@if (Session::has('alerts'))
    @foreach (Session::get('alerts') as $alert)
        @include ('forum::partials.alert', $alert)
    @endforeach
@endif
