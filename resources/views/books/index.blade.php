<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Books</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
</head>

<body>
    <h1>home</h1>

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
                <th></th>
            </tr>
            @foreach($books as $book)
                <tr>
                    <div class='book'>
                        
                        <!--<th>-->
                        <!--    <form action="/home/{{$book->id}}/complete" id="form_{{$book->id}}" method="post">-->
                        <!--        @csrf-->
                        <!--        @method('PUT')-->
                        <!--        <button type="button" onclick="completeTask({{$book->id}})">complete</button>-->
                        <!--    </form>-->
                        <!--</th>-->
                        <!--<th>-->
                        <!--    @if(($book->label_id)!=NULL)-->
                        <!--    <a href="/label/{{$book->label_id}}">{{$book->label->name}}</a>-->
                        <!--    @endif-->
                        <!--</th>-->
                        <th>
                            {{$book->today_finished/$book->max*100}}%
                        </th>
                        <th>
                            <a href="/index/{{$book->id}}">{{$book->name}}</a>
                        </th>
                        <th>
                            {{$book->subject->name}}
                        </th>
                        <th>
                            <div style="color:red">{{$book->next_learn_at}}</div>
                        </th>
                        <th>
                            {{$book->a_day}}{{$book->type->name}}
                        </th>
                        <th>
                            {{$book->intarval->name}}
                        </th>
                        <!--<th>-->
                        <!--    <form action="/home/{{$book->id}}" id="form_{{$book->id}}" method="post">-->
                        <!--        @csrf-->
                        <!--        @method('DELETE')-->
                        <!--        <button type="button" onclick="deleteTask({{$book->id}})">delete</button>-->
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