<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
        <head>
            <meta charset="utf-8">
            <title>Today</title>
            <!-- Fonts -->
            <link rel="preconnect" href="https://fonts.bunny.net">
            <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
            <!-- Scripts -->
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        </head>
        <body>
            <div class="w-full h-auto">
                <div id='calendar'></div>
            </div>
            
        </body>

    </x-app-layout>
</html>