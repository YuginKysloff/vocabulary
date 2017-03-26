<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Vocabulary') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <header class="header">
        <div class="header__wrapper">
            <div class="header__logo">
                <a href="{{ route('vocabulary') }}"><strong>{{ strtoupper(config('app.name', 'Vocabulary')) }}</strong></a>
            </div>
            @if (Auth::user())
                <nav class="header__nav">
                    <ul>
                        <li>
                            <a href="{{ route('account', ['id' => auth()->user()->id]) }}" title="Get your favorites words">{{ ucfirst(auth()->user()->name) }}</a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();" title="Leave the application">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </nav>
            @endif
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    <footer class="footer">
        <p class="footer__text">All right reserved &#169; {{ date('Y') }}</p>
    </footer>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
