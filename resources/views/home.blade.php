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
            <div class="flex justify-center">
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <h1 class="txt-h1"><a href="{{ url('/today') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Today</a></h1>
                    @else
                        <h1><a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a></h1>
    
                        @if (Route::has('register'))
                            <h1><a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a></h1>
                        @endif
                    @endauth
                </div>
            </div>
        @endif
    </body>
</html>