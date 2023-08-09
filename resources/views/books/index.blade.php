<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Books</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
</head>

<body>
    <a href="/today">today</a>
    <br>
    <a href="/books/create">create</a>
    <br>
    <a href="/label">label</a>
    <br>
    
    <h2>参考書一覧</h2>
    <div class='books'>
        <table border="1">
            <tr>
                <th>進捗率</th>
                <th>参考書名</th>
                <th>教科</th>
                <th>次回予定日</th>
                <th>一日実施量</th>
                <th>学習間隔</th>
                <th>終了予定日</th>
            </tr>
            @foreach($book_mgmts as $book_mgmt)
                <tr>
                    <div class='book'>
                        <th>
                            {{$book_mgmt->book->today_finished/$book_mgmt->book->max*100}}%
                        </th>
                        <th>
                            <a href="/books/{{$book_mgmt->book_id}}">{{$book_mgmt->book->name}}</a>
                        </th>
                        <th>
                            {{$book_mgmt->book->subject->name}}
                        </th>
                        <th>
                            <div style="color:red">{{$book_mgmt->next_learn_at}}</div>
                        </th>
                        <th>
                            {{$book_mgmt->a_day}}{{$book_mgmt->book->type->name}}
                        </th>
                        <th>
                            {{$book_mgmt->intarval->name}}
                        </th>
                        <th>
                            {{$book_mgmt->end_date}}
                        </th>
                        <!--<th>-->
                        <!--    <form action="/home/{{$book_mgmt->id}}" id="form_{{$book_mgmt->id}}" method="post">-->
                        <!--        @csrf-->
                        <!--        @method('DELETE')-->
                        <!--        <button type="button" onclick="deleteTask({{$book_mgmt->id}})">delete</button>-->
                        <!--    </form>-->
                        <!--</th>-->
                        
                    </div>
                </tr>
            @endforeach
        </table>
    </div>
        <script>
            function completeTask(id){
                'use strict'
                if(confirm('complete?')){
                    document.getElementById(`form_${id}`).submit();
                }
                
            }
            function deleteTask(id){
                'use strict'
                
                if(confirm('delete? \n not come back')){
                    document.getElementById(`form_${id}`).submit();
                }
            }
        </script>
    </body>
</html>