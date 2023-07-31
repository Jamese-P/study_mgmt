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
        <h1 class="name">{{$book->name}}</h1>
        <h2 class="subject">{{$book->subject->name}}</h2>
        <h2>進捗率：{{$book->today_finished/$book->max*100}}%</h2>
        <h2 class="max">終了{{$book->type->name}}:{{$book->max}}</h2>
        <h2>{{$book->intarval->name}}{{$book->a_day}}{{$book->type->name}}</h2>
        <h2 class="next_learn_at">次の学習日は{{$book->next_learn_at}}</h2>
        
        <a href="/books/{{$book->id}}/edit">edit</a>
        <a href="/today">back</a>
        
        <h2>学習履歴</h2>
        <table border="1" style="border-collapse: collapse">
            <tr>
                <th>{{$book->type->name}}</th>
                <th>学習日時</th>
                <th>理解度</th>
                <th>コメント</th>
            </tr>
            @foreach($logs as $log)
                <tr>
                    <th>{{$log->number}}</th>
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
        
    </body>
</html>