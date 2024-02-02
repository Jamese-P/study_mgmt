<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ファイル</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    </head>
    <body>
        <h3><a href="{{route('print.main')}}">main</a></h3>
        <h3><a href="{{route('print.high')}}">高校生</a></h3>
        <h3><a href="{{route('print.sinken')}}">進研模試</a></h3>
        <h3><a href="{{route('print.eiken')}}">英検</a></h3>
    </body>
</html>