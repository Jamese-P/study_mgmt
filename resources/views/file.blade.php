<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    </head>
    <body>
        @foreach($files as $file)
            @if($file->getExtension()=="xlsm")
                <a href="files/{{$file->getfileName()}}" download="{{$file->getfileName()}}"><p>{{$file->getfileName()}}</p></a>
            @else
                <a href="files/{{$file->getfileName()}}" target="_blank"><p>{{$file->getfileName()}}</p></a>
            @endif
        @endforeach
    </body>
</html>