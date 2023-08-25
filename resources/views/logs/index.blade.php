<x-app-layout>
    <x-slot name="header">
        学習履歴
    </x-slot>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Logs</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class='logs'>
        <table class="log-table">
            <thead class="log-thead">
                <tr>
                    <th class="log-th" scope="col">@sortablelink('subject', '教科')</th>
                    <th class="log-th" scope="col">参考書名</th>
                    <th class="log-th" scope="col"></th>
                    <th class="log-th" scope="col">@sortablelink('learned_at', '学習日')</th>
                    <th class="log-th" scope="col">@sortablelink('comprehension_id', '理解度')</th>
                    <th class="log-th">コメント</th>
                </tr>
            </thead>
            <tbody>
            @foreach($logs as $log)
                <tr class="log-tr">
                    <td class="log-td">{{$log->book->subject->name}}</td>
                    <td class="log-td"><a class="link" href="/books/{{$log->book->id}}">{{$log->book->name}}</a></td>
                    <td class="log-td">{{$log->book->type->name}}{{$log->number}}</td>
                    <td class="log-td">{{$log->learned_at}}</td>
                    <td class="log-td">{{$log->comprehension->name}}</td>
                    <td class="log-td">{{$log->comment}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <script>
        
    </script>
</body>
</html>
</x-app-layout>