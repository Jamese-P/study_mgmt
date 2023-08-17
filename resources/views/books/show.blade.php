<x-app-layout>
    <x-slot name="header">
        参考書詳細
    </x-slot>
<!DOCTYPE HTML>
<html lang="{{str_replace('_','_',app()->getLocale())}}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Book</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1 class="name">{{$book_mgmt->book->name}}</h1>
        <h2 class="subject">{{$book_mgmt->book->subject->name}}</h2>
        <h2>進捗率：{{round($book_mgmt->finished/$book_mgmt->book->max*100,1)}}%</h2>
        <h2 class="max">終了{{$book_mgmt->book->type->name}}:{{$book_mgmt->book->max}}</h2>
        <h2>{{$book_mgmt->intarval->name}}{{$book_mgmt->a_day}}{{$book_mgmt->book->type->name}}</h2>
        <h2 class="next_learn_at">次の学習日は{{$book_mgmt->next_learn_at}}</h2>
        <h2 class="end_date">終了予定日：{{$book_mgmt->end_date}}</h2>
        
        <a href="/books/{{$book_mgmt->book->id}}/edit">edit</a>
        <a href="/today">back</a>
        
        <h2>学習履歴</h2>
        <div class='logs'>
        <table class="log-table">
            <thead class="log-thead">
                <tr>
                    <th class="log-th">{{$book_mgmt->book->type->name}}</th>
                    <th class="log-th">学習日時</th>
                    <th class="log-th">理解度</th>
                    <th class="log-th">コメント</th>
                </tr>
            </thead>
            <tbody>
            @foreach($logs as $log)
                <tr class="log-tr">
                    <td class="log-td">{{$log->number}}</td>
                    <td class="log-td">{{$log->learned_at}}</td>
                    <td class="log-td">{{$log->comprehension->name}}</td>
                    <td class="log-td">{{$log->comment}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    </body>
</html>
</x-app-layout>