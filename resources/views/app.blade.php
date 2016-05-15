<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link href="{{ elixir('css/trn.css') }}" rel="stylesheet">
</head>
<body>
    <div class="navbar-fixed">
        <nav>
            <div class="container">
                <div class="nav-wrapper">
                    <a href="{{ url('/') }}" class="brand-logo left">[TRN]</a>
                        @if (Auth::guest())
                            <ul class="right">
                                <li><a href="{{ url('auth/login') }}">Login</a></li>
                                <li><a href="{{ url('auth/register') }}">Register</a></li>
                            </ul>
                        @else
                            <ul class="right">
                                <li><a class="dropdown-button" href="#!" data-activates="user-links" data-beloworigin="true" data-constrainwidth="false" data-hover="true">Hello, <strong>{{ Auth::user()->name }}</strong>!&nbsp; <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
                            </ul>
                            <ul id="user-links" class="dropdown-content">
                                <li><a href="{{ url('auth/logout') }}">Log out</a></li>
                            </ul>
                        @endif
                </div>
            </div>
        </nav>
    </div>

    <div id="main">
        <div id="splash">
            <div class="container">
                <h1>@yield('title')</h1>
                <p>@yield('subtitle')</p>
            </div>
        </div>
        <div id="content">
            <div class="container">
                <div id="inner" class="z-depth-1">
                    {!! Notification::showAll() !!}

                    @if (count($errors) > 0)
                        <div class="alert error">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="{{ elixir('js/trn.js') }}"></script>

    <script>
    if ($('textarea').length) {
        var editor = new Editor();
        editor.render();
    }

    $('nav li a').not('.dropdown-button').each(function () {
        var href = this.pathname;
        if (href === window.location.pathname) {
            $(this).parent('li').addClass('active');
        }
    });
    </script>
</body>
</html>
