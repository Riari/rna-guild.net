@extends('app')

@section('title', 'Disconnect login')

@section('content')
<div class="row">
    <div class="col m6 offset-m3">
        <form method="POST" action="{{ route('account.disconnect-login', $key) }}">
            {!! csrf_field() !!}

            <p>Disconnect your <strong>{{ $provider }}</strong> login?</p>

            <div class="row">
                <div class="input-field col s12 right-align">
                    <button type="submit" class="waves-effect waves-light btn-large">
                        Yes please
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
