<x-app-layout>
    <x-slot name="header">
        参考書一覧
    </x-slot>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Books</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
</head>

<body>
    <a href="/books/create">create</a>
    <br>
    
    <h2>学習中参考書</h2>
    <div class='books'>
        <table border="1">
            <tr>
                <th>進捗率</th>
                <th>参考書名</th>
                <th>教科</th>
                <th>次回予定日</th>
                <th>学習間隔</th>
                <th>実施量</th>
                <th>終了</th>
                <th>終了予定日</th>
            </tr>
            @foreach($book_mgmts as $book_mgmt)
                <tr>
                    <div class='book'>
                        <th>
                            <div class="percent">
                            {{$book_mgmt->today_finished/$book_mgmt->book->max*100}}%
                            </div>
                        </th>
                        <th>
                            <div class="name">
                            <a href="/books/{{$book_mgmt->book_id}}">{{$book_mgmt->book->name}}</a>
                            </div>
                        </th>
                        <th>
                            <div class="subject">
                            {{$book_mgmt->book->subject->name}}
                            </div>
                        </th>
                        <th>
                            <div class="next_learn_at" style="color:red">
                            {{$book_mgmt->next_learn_at}}
                            </div>
                        </th>
                        <th>
                            <div class="intarval">
                            {{$book_mgmt->intarval->name}}
                            </div>
                        </th>
                        <th>
                            <div class="a_day">
                            {{$book_mgmt->a_day}}{{$book_mgmt->book->type->name}}
                            </div>
                        </th>
                        <th>
                            <div class="max">
                                {{$book_mgmt->book->max}}
                            </div>
                        </th>
                        <th>
                            <div class="end_date">
                            {{$book_mgmt->end_date}}
                            </div>
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
    
    <div>
        <h2>学習済み参考書</h2>
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
</x-app-layout>