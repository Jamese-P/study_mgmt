<x-app-layout>
    <x-slot name="header">
        Today
    </x-slot>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Today</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
</head>

<body>
    <a href="{{route('today.comp_indiv')}}">学習登録</a>
    <br>
    <h1>期限切れ</h1>
        @foreach($books_exp as $book_mgmt)
        <p>{{$book_mgmt->book->name}}</p>
        @endforeach
    <br>
    <h1>Today {{\Carbon\Carbon::today()->format('Y/m/d')}}</h1>
        @foreach($books_today as $book_mgmt)
            <div class='book'>
                <h2><a href="/books/{{$book_mgmt->book->id}}">{{$book_mgmt->book->name}}</a> 残り{{$book_mgmt->today_rest}}{{$book_mgmt->book->type->name}}</h2>
                <table>
                    <tr>
                        @if ($book_mgmt->today_rest>0)
                        <th>
                            {{$book_mgmt->book->type->name}}{{$book_mgmt->next}}
                        </th>
                        <th>
                            <form action="/today/{{$book_mgmt->book_id}}/{{$book_mgmt->next}}/complete" id="form_{{$book_mgmt->book_id}}_complete" method="get">
                                @csrf
                                <button type="button" onclick="complete({{$book_mgmt->book_id}})">complete</button>
                            </form>
                        </th>
                        <th>
                            <form action="/today/{{$book_mgmt->book_id}}/{{$book_mgmt->next}}/pass" id="form_{{$book_mgmt->book_id}}_pass" method="post">
                                @csrf
                                @method('PUT')
                                <button type="button" onclick="pass({{$book_mgmt->book_id}})">pass</button>
                            </form>
                        </th>
                        @endif
                    </tr>
                </table>
            </div>
        @endforeach
    
    <br>
    <h1>Tommorow {{\Carbon\Carbon::tomorrow()->format('Y/m/d')}}</h1>
        @foreach($books_today as $book_mgmt)
            @if ($book_mgmt->intarval_id=='1' && $book_mgmt->book->max > $book_mgmt->finished)
            <div class='book'>
                <h2><a href="/books/{{$book_mgmt->book->id}}">{{$book_mgmt->book->name}}</a></h2>
                <table>
                    <tr>
                        @if ($book_mgmt->next > $book_mgmt->finished)
                        <th>
                            {{$book_mgmt->book->type->name}}{{$book_mgmt->next}}
                        </th>
                        <th>
                            <form action="/today/{{$book_mgmt->book_id}}/{{$book_mgmt->next}}/complete" id="form_{{$book_mgmt->book_id}}_complete" method="get">
                                @csrf
                                <button type="button" onclick="complete({{$book_mgmt->book_id}})">complete</button>
                            </form>
                        </th>
                        <th>
                            <form action="/today/{{$book_mgmt->book_id}}/{{$book_mgmt->next}}/pass" id="form_{{$book_mgmt->book_id}}_pass" method="post">
                                @csrf
                                @method('PUT')
                                <button type="button" onclick="pass({{$book_mgmt->book_id}})">pass</button>
                            </form>
                        </th>
                        @endif
                    </tr>
                </table>
            </div>
            @endif
        @endforeach
        
        @foreach($books_tomorrow as $book_mgmt)
            <div class='book'>
                <h2><a href="/books/{{$book_mgmt->book->id}}">{{$book_mgmt->book->name}}</a> 残り{{$book_mgmt->today_rest}}{{$book_mgmt->book->type->name}}</h2>
                <table>
                    <tr>
                        @if ($book_mgmt->today_rest!=0)
                        <th>
                            {{$book_mgmt->book->type->name}}{{$book_mgmt->next}}
                        </th>
                        <th>
                            <form action="/today/{{$book_mgmt->book_id}}/{{$book_mgmt->next}}/complete" id="form_{{$book_mgmt->book_id}}_complete" method="get">
                                @csrf
                                <button type="button" onclick="complete({{$book_mgmt->book_id}})">complete</button>
                            </form>
                        </th>
                        <th>
                            <form action="/today/{{$book_mgmt->book_id}}/{{$book_mgmt->next}}/pass" id="form_{{$book_mgmt->book_id}}_pass" method="post">
                                @csrf
                                @method('PUT')
                                <button type="button" onclick="pass({{$book_mgmt->book_id}})">pass</button>
                            </form>
                        </th>
                        @endif
                    </tr>
                </table>
            </div>
        @endforeach
        
    <br>
    
    <script>
        function complete(id){
            'use strict'
            if(confirm('完了しますか？')){
                document.getElementById(`form_${id}_complete`).submit();
            }
            
        }
        function pass(id){
            'use strict'
            
            if(confirm('本当にパスしますか？')){
                document.getElementById(`form_${id}_pass`).submit();
            }
        }
        
        window.onload = function(){
            if(!@json($books_exp)){
                if(confirm('期限切れがあります。\n処理してください。')){
                    
                }
            }
        }
    </script>
</body>
</html>
</x-app-layout>