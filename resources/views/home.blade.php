<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Login</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        @if (Route::has('login'))
            <div class="h-screen w-screen flex justify-center items-center">
                <div>学習管理アプリ</div>
                    @auth
                        <h1 class="txt-h1"><a href="{{ url('/today') }}" class="">Today</a></h1>
                    @else
                        <h1  class="txt-h1"><a href="{{ route('login') }}" class="">Log in</a></h1>
    
                        @if (Route::has('register'))
                            <h1  class="txt-h1"><a href="{{ route('register') }}" class="">Register</a></h1>
                        @endif
                    @endauth
            </div>
        @endif
    </body>
</html>