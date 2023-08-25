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
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="grid2">
        <div>
            <h2 class="txt-h2">学習中参考書</h2>
            <div class='books'>
                <table class="book-table">
                    <thead class="book-thead">
                        <tr>
                            <th class="book-th">進捗</th>
                            <th class="book-th">参考書名</th>
                            <th class="book-th">教科</th>
                            <th class="book-th">次回</th>
                            <th class="book-th">学習スピード</th>
                            <th class="book-th">終了</th>
                            <th class="book-th">終了予定日</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                    @foreach($book_progress as $book_mgmt)
                        <tr class="book-tr">
                            <div class='book'>
                                <td class="book-td">
                                    <div class="percent">
                                    {{$book_mgmt->percent}}%
                                    </div>
                                </td>
                                <td class="book-td">
                                    <div class="name">
                                    <a class="link" href="/books/{{$book_mgmt->book_id}}">{{$book_mgmt->book->name}}</a>
                                    </div>
                                </td>
                                <td class="book-td">
                                    <div class="subject">
                                    {{$book_mgmt->book->subject->name}}
                                    </div>
                                </td>
                                <td class="book-td">
                                    <div class="next_learn_at" style="color:red">
                                    {{$book_mgmt->next_learn_at}}
                                    </div>
                                    <div class="next">
                                    {{$book_mgmt->book->type->name}}{{$book_mgmt->next}}
                                    </div>
                                </td>
                                <td class="book-td">
                                    <div class="intarval">{{$book_mgmt->intarval->name}}</div>
                                    <div class="a_day">{{$book_mgmt->a_day}}{{$book_mgmt->book->type->name}}</div>
                                </td>
                                <td class="book-td">
                                    <div class="max">
                                        {{$book_mgmt->book->type->name}}{{$book_mgmt->book->max}}
                                    </div>
                                </td>
                                <td class="book-td">
                                    <div class="end_date">
                                    {{$book_mgmt->end_date}}
                                    </div>
                                </td>
                            </div>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div>
            <h2 class="txt-h2">学習済み参考書</h2>
            <div class='books'>
                <table class="book-table">
                    <thead class="book-thead">
                        <tr>
                            <th class="book-th">進捗</th>
                            <th class="book-th">参考書名</th>
                            <th class="book-th">教科</th>
                            <th class="book-th">学習スピード</th>
                            <th class="book-th">終了</th>
                            <th class="book-th">終了日</th>
                            <th class="book-th"></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                    @foreach($book_finish as $book_mgmt)
                        <tr class="book-tr">
                            <div class='book'>
                                <td class="book-td">
                                    <div class="percent">
                                    {{$book_mgmt->percent}}%
                                    </div>
                                </td>
                                <td class="book-td">
                                    <div class="name">
                                    <a class="link" href="/books/{{$book_mgmt->book_id}}">{{$book_mgmt->book->name}}</a>
                                    </div>
                                </td>
                                <td class="book-td">
                                    <div class="subject">
                                    {{$book_mgmt->book->subject->name}}
                                    </div>
                                </td>
                                <td class="book-td">
                                    <div class="intarval">{{$book_mgmt->intarval->name}}</div>
                                    <div class="a_day">{{$book_mgmt->a_day}}{{$book_mgmt->book->type->name}}</div>
                                </td>
                                <td class="book-td">
                                    <div class="max">
                                        {{$book_mgmt->book->max}}
                                    </div>
                                </td>
                                <td class="book-td">
                                    <div class="end_date">
                                    {{$book_mgmt->end_date}}
                                    </div>
                                </td>
                                <td class="book-td">
                                    <form action="/books/{{$book_mgmt->book_id}}/relearn" id="form_{{$book_mgmt->id}}" method="get">
                                        <button type="button" class="btn-comp" onclick="relearn({{$book_mgmt->id}})">再学習</button>
                                    </form>
                                </td>
                            </div>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
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