<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="content-language" content="ja">

        <title>ファイル</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/file.css'])
    </head>
    <body>
        <div class="navigation">
                <ul>
                    <li><a href="{{ route('print.main') }}">main</a></li>
                    <li><a href="{{ route('print.high') }}">高校生</a></li>
                    <li><a href="{{ route('print.sinken') }}">進研模試</a></li>
                    <li><a href="{{ route('print.eiken') }}">英検</a></li>
                </ul>
        </div>
        @yield('content')
    </body>
</html>