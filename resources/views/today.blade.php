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
    
    <h1>期限切れ</h1>
    
    
    <h1>Today {{\Carbon\Carbon::today()->format('Y/m/d')}}</h1>
        @foreach($books_today as $book_mgmt)
            <div class='book'>
                <h2><a href="/books/{{$book_mgmt->book_id}}">{{$book_mgmt->book->name}}</a></h2>
                <table>
                    @for ($i = 0; $i<($book_mgmt->a_day); $i++)
                    @if ($book_mgmt->book->max >= $book_mgmt->finished+$i+1)
                        <tr>
                            @if ($book_mgmt->today_finished == ($book_mgmt->finished + $i))
                            <th>
                                <a href="/today/{{$book_mgmt->book->id}}/{{$book_mgmt->finished + $i+1}}/complete">
                                    {{$book_mgmt->book->type->name}}{{$book_mgmt->finished+$i+1}}
                                </a>
                            </th>
                            @else
                            <th>
                                {{$book_mgmt->book->type->name}}{{$book_mgmt->finished+$i+1}}
                            </th>
                            @endif
                            @if ($book_mgmt->today_finished == ($book_mgmt->finished + $i))
                                <th>
                                    <form action="/today/{{$book_mgmt->book_id}}/{{$book_mgmt->today_finished+1}}/complete" id="form_{{$book_mgmt->book_id}}_complete" method="get">
                                        @csrf
                                        <button type="button" onclick="complete({{$book_mgmt->book_id}})">complete</button>
                                    </form>
                                </th>
                                <th>
                                    <form action="/today/{{$book_mgmt->book_id}}/pass" id="form_{{$book_mgmt->book_id}}_pass" method="post">
                                        @csrf
                                        <button type="button" onclick="pass({{$book_mgmt->book_id}})">pass</button>
                                    </form>
                                </th>
                            @endif
                        </tr>
                    @endif
                    @endfor
                </table>
            </div>
        @endforeach
        
    <h1>Tommorow {{\Carbon\Carbon::tomorrow()->format('Y/m/d')}}</h1>
        @foreach($books_today as $book_mgmt)
            @if ($book_mgmt->intarval_id=='1' && $book_mgmt->book->max > $book_mgmt->finished+$book_mgmt->a_day)
            <div class='book'>
                <h2><a href="/books/{{$book_mgmt->book_id}}">{{$book_mgmt->book->name}}</a></h2>
                <table>
                    @for ($i = 0; $i<($book_mgmt->a_day); $i++)
                    @if ($book_mgmt->book->max >= $book_mgmt->finished+$book_mgmt->a_day+$i+1)
                        <tr>
                            @if ($book_mgmt->today_finished == ($book_mgmt->finished+$book_mgmt->a_day + $i))
                            <th>
                                <a href="/today/{{$book_mgmt->book_id}}/{{$book_mgmt->finished+$book_mgmt->a_day + $i+1}}/complete">
                                    {{$book_mgmt->book->type->name}}{{$book_mgmt->finished+$book_mgmt->a_day+$i+1}}
                                </a>
                            </th>
                            @else
                            <th>
                                {{$book_mgmt->book->type->name}}{{$book_mgmt->finished+$book_mgmt->a_day+$i+1}}
                            </th>
                            @endif
                            @if ($book_mgmt->today_finished == ($book_mgmt->finished+$book_mgmt->a_day + $i))
                                <th>
                                    <form action="/today/{{$book_mgmt->book_id}}/{{$book_mgmt->today_finished+1}}/complete" id="form_{{$book_mgmt->book_id}}_complete" method="get">
                                        @csrf
                                        <button type="button" onclick="complete({{$book_mgmt->book_id}})">complete</button>
                                    </form>
                                </th>
                                <th>
                                    <form action="/today/{{$book_mgmt->book_id}}/pass" id="form_{{$book_mgmt->book_id}}_pass" method="post">
                                        @csrf
                                        <button type="button" onclick="pass({{$book_mgmt->book_id}})">pass</button>
                                    </form>
                                </th>
                            @endif
                        </tr>
                    @endif
                    @endfor
                </table>
            </div>
            @endif
        @endforeach
        
        @foreach($books_tomorrow as $book_mgmt)
            <div class='book'>
                <h2><a href="/books/{{$book_mgmt->book_id}}">{{$book_mgmt->book->name}}</a></h2>
                <table>
                    @for ($i = 0; $i<($book_mgmt->a_day); $i++)
                    @if ($book_mgmt->book->max >= $book_mgmt->finished+$i+1)
                        <tr>
                            @if ($book_mgmt->today_finished == ($book_mgmt->finished + $i))
                            <th>
                                <a href="/today/{{$book_mgmt->book->id}}/{{$book_mgmt->finished + $i+1}}/complete">
                                    {{$book_mgmt->book->type->name}}{{$book_mgmt->finished+$i+1}}
                                </a>
                            </th>
                            @else
                            <th>
                                {{$book_mgmt->book->type->name}}{{$book_mgmt->finished+$i+1}}
                            </th>
                            @endif
                            @if ($book_mgmt->today_finished == ($book_mgmt->finished + $i))
                                <th>
                                    <form action="/today/{{$book_mgmt->book_id}}/{{$book_mgmt->today_finished+1}}/complete" id="form_{{$book_mgmt->book_id}}_complete" method="get">
                                        @csrf
                                        <button type="button" onclick="complete({{$book_mgmt->book_id}})">complete</button>
                                    </form>
                                </th>
                                <th>
                                    <form action="/today/{{$book_mgmt->book_id}}/pass" id="form_{{$book_mgmt->book_id}}_pass" method="post">
                                        @csrf
                                        <button type="button" onclick="pass({{$book_mgmt->book_id}})">pass</button>
                                    </form>
                                </th>
                            @endif
                        </tr>
                    @endif
                    @endfor
                </table>
            </div>
        @endforeach
        
    <br>
    <a href="/books/create">create</a>
    
    <script>
        function complete(id){
            'use strict'
            if(confirm('complete?')){
                document.getElementById(`form_${id}_complete`).submit();
            }
            
        }
        function pass(id){
            'use strict'
            
            if(confirm('pass?')){
                document.getElementById(`form_${id}_pass`).submit();
            }
        }
    </script>
</body>
</html>
</x-app-layout>