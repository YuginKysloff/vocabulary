<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Vocabulary') }}</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,700" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="welcome__wrapper">
            <header>
                <h1 class="welcome__title">{{ strtoupper(config('app.name', 'Vocabulary')) }}</h1>
            </header>
            <p class="welcome__desc">
                Hi, Guys!
                We glad represent to you solution of encoding any words to few type of hashes.<br>
                To start you should <strong><a href="{{ url('/login') }}" class="welcome__link">Login</a></strong> or
                <strong><a href="{{ url('/register') }}" class="welcome__link">Register</a></strong>.
            </p>
        </div>
    </body>
</html>
