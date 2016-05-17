<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Rusty Nails Adventurers - @yield('title') - @yield('subtitle')</title>

    <link href="{{ elixir('css/trn.css') }}" rel="stylesheet">
</head>
<body class="@yield('body_class')">
    <div id="top-bar" class="navbar-fixed">
        <nav>
            <div class="container">
                <div class="nav-wrapper">
                    <a href="{{ url('/') }}" class="brand-logo left">[RNA]</a>
                    <ul class="right">
                        <li><a class="dropdown-button" href="{{ url('forum') }}" data-activates="forum-links" data-beloworigin="true" data-constrainwidth="false" data-hover="true">Forum&nbsp; <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
                        <li><a href="{{ url('events') }}">Events</a></li>
                        @if (Auth::guest())
                            <li><a href="{{ url('auth/login') }}">Login</a></li>
                            <li><a href="{{ url('auth/register') }}">Register</a></li>
                        @else
                            @can('admin')
                                <li><a class="dropdown-button" href="{{ url('admin') }}" data-activates="admin-links" data-beloworigin="true" data-constrainwidth="false" data-hover="true">Admin&nbsp; <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
                            @endcan
                            <li><a class="dropdown-button" href="#!" data-activates="user-links" data-beloworigin="true" data-constrainwidth="false" data-hover="true">Hello, <strong>{{ Auth::user()->name }}</strong>!&nbsp; <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
                        @endif
                    </ul>
                    <ul id="forum-links" class="dropdown-content">
                        <li><a href="{{ url('forum') }}">Forum index</a></li>
                        <li><a href="{{ url('forum/new') }}">New & updated</a></li>
                    </ul>
                    @if (Auth::check())
                        @can('admin')
                            <ul id="admin-links" class="dropdown-content">
                                <li><a href="{{ url('admin/article') }}">Articles</a></li>
                                <li><a href="{{ url('admin/event') }}">Events</a></li>
                                <li><a href="{{ url('admin/forum/category') }}">Forum Categories</a></li>
                            </ul>
                        @endcan
                        <ul id="user-links" class="dropdown-content">
                            <li><a href="{{ url('account/profile') }}">View profile</a></li>
                            <li><a href="{{ url('account/profile/edit') }}">Edit profile</a></li>
                            <li><a href="{{ url('account/settings') }}">Account settings</a></li>
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
                    @if (array_key_exists('breadcrumbs', View::getSections()))
                        <nav class="breadcrumbs z-depth-0">
                            <div class="nav-wrapper">
                                <div class="col s12">
                                    <a href="{{ url('/') }}" class="breadcrumb">Home</a>
                                    @section('breadcrumbs')
                                    @show
                                </div>
                            </div>
                        </nav>
                    @endif

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

                @yield('after_content')
            </div>
            <div id="footer">
                <div class="container">
                    <div class="inner">
                        Built by Febby. All times are displayed in UTC.
                    </div>
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

    $('select').material_select();

    $('nav li a').not('.dropdown-button').each(function () {
        var href = this.pathname;
        if (href === window.location.pathname) {
            $(this).parent('li').addClass('active');
        }
    });

    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-77914915-1', 'auto');
    ga('send', 'pageview');
    </script>
    @yield('bottom')
</body>
</html>
