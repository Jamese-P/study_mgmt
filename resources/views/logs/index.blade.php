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
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
</head>

<body>
    <h2>学習履歴</h2>
    <div class='logs'>
        <table border="1" style="border-collapse: collapse">
            <tr>
                <th>参考書名</th>
                <th>教科</th>
                <th></th>
                <th>学習日時</th>
                <th>理解度</th>
                <th>コメント</th>
            </tr>
            @foreach($logs as $log)
                <tr>
                    <th>{{$log->book->name}}</th>
                    <th>{{$log->book->subject->name}}</th>
                    <th>{{$log->book->type->name}}{{$log->number}}</th>
                    <th>{{$log->learned_at}}</th>
                    <th>{{$log->comprehension->name}}</th>
                    <th>
                        @if($log->comment != 'NULL')
                            {{$log->comment}}
                        @endif
                    </th>
                </tr>
            @endforeach
        </table>
    </div>
        
        

        <script>
            function relearn(id){
                'use strict'
                
                if(confirm('再学習しますか？')){
                    document.getElementById(`form_${id}`).submit();
                }
            }
        </script>
    </body>
</html>
</x-app-layout>