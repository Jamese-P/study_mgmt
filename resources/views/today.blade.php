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
        @foreach($books_today as $book)
            <div class='book'>
                <h2><a href="/books/{{$book->id}}">{{$book->name}}</a></h2>
                <table>
                    @for ($i = 0; $i<($book->a_day); $i++)
                    @if ($book->max >= $book->finished+$i+1)
                        <tr>
                            @if ($book->today_finished == ($book->finished + $i))
                            <th>
                                <a href="/today/{{$book->id}}/{{$book->finished + $i+1}}/complete">{{$book->type->name}}{{$book->finished+$i+1}}</a>
                            </th>
                            @else
                            <th>
                                {{$book->type->name}}{{$book->finished+$i+1}}
                            </th>
                            @endif
                            @if ($book->today_finished == ($book->finished + $i))
                                <th>
                                    <form action="/today/{{$book->id}}/complete" id="form_{{$book->id}}_complete" method="post">
                                        @csrf
                                        <button type="button" onclick="complete({{$book->id}})">complete</button>
                                    </form>
                                </th>
                                <th>
                                    <form action="/today/{{$book->id}}/pass" id="form_{{$book->id}}_pass" method="post">
                                        @csrf
                                        <button type="button" onclick="pass({{$book->id}})">pass</button>
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
        <div class='book'>
        @foreach($books_today as $book)
            @if ($book->intarval_id=='1')
                <h2><a href="/books/{{$book->id}}">{{$book->name}}</a></h2>
                <table>
                    @for ($i = 0; $i<($book->a_day); $i++)
                        @if ($book->max >= $book->finished+$book->a_day+$i+1)
                        <tr>
                            @if ($book->today_finished == ($book->finished +$book->a_day+ $i))
                            <th>
                                <a href="/today/{{$book->id}}/{{$book->finished +$book->a_day+ $i+1}}/complete">{{$book->type->name}}{{$book->finished+$book->a_day+$i+1}}</a>
                            </th>
                            @else
                            <th>
                                {{$book->type->name}}{{$book->finished+$book->a_day+$i+1}}
                            </th>
                            @endif
                            @if ($book->today_finished == ($book->finished +$book->a_day+ $i))
                            <th>
                                <form action="/today/{{$book->id}}/complete" id="form_{{$book->id}}_complete" method="post">
                                    @csrf
                                    <button type="button" onclick="complete({{$book->id}})">complete</button>
                                </form>
                            </th>
                            <th>
                                <form action="/today/{{$book->id}}/pass" id="form_{{$book->id}}_pass" method="post">
                                    @csrf
                                    <button type="button" onclick="pass({{$book->id}})">pass</button>
                                </form>
                            </th>
                            @endif
                        </tr>
                        @endif
                    @endfor
                </table>
            @endif
        @endforeach
        @foreach($books_tomorrow as $book)
            
            <h2><a href="/books/{{$book->id}}">{{$book->name}}</a></h2>
            <table>
                @for ($i = 0; $i<($book->a_day); $i++)
                @if ($book->max >= $book->finished+$i+1)
                    <tr>
                        @if ($book->today_finished == ($book->finished + $i))
                        <th>
                            <a href="/today/{{$book->id}}/{{$book->finished + $i+1}}/complete">{{$book->type->name}}{{$book->finished+$i+1}}</a>
                        </th>
                        @else
                        <th>
                            {{$book->type->name}}{{$book->finished+$i+1}}
                        </th>
                        @endif
                        @if ($book->today_finished == ($book->finished + $i))
                        <th>
                            <form action="/today/{{$book->id}}/complete" id="form_{{$book->id}}_complete" method="post">
                                @csrf
                                <button type="button" onclick="complete({{$book->id}})">complete</button>
                            </form>
                        </th>
                        <th>
                            <form action="/today/{{$book->id}}/pass" id="form_{{$book->id}}_pass" method="post">
                                @csrf
                                <button type="button" onclick="pass({{$book->id}})">pass</button>
                            </form>
                        </th>
                        @endif
                    </tr>
                @endif
                @endfor
            </table>
        @endforeach
        </div>

    <a href="/">参考書一覧</a>
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