<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Today</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
</head>

<body>
    <h1>Today</h1>
        @foreach($books as $book)
            <div class='book'>
                <h2><a href="/books/{{$book->id}}">{{$book->name}}</a></h2>
                <table>
                    @for ($i = 0; $i<($book->a_day); $i++)
                        <tr>
                            <th>
                                @if ($book->type_id == 1)
                                    {{$book->type->name}}{{$book->finished+$i+1}}
                                @elseif ($book->type_id == 2)
                                    {{$book->finished+$i+1}}{{$book->type->name}}
                                @endif
                            </th>
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
                    @endfor
                </table>
            </div>
            
        @endforeach
        
    <h1>Tommorow</h1>
        
    

    <a href="/home/calendar">calendar</a>
    <br>
    <a href="/home/create">create</a>
    <br>
    <a href="/label">label</a>
    <br>
    
    
           
        
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