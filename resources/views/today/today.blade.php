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
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="grid3">
    
        <div class="exp">
            @if(!$books_exp->isEmpty())
            <h1 class="txt-h1">期限切れの参考書</h1>
            <div class="books">
                <table class="book-table">
                    <thead class="book-thead">
                        <tr>
                            <th class="book-th">参考書名</th>
                            <th class="book-th">残り</th>
                            <th class="book-th"></th>
                            <th class="book-th"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($books_exp as $book_mgmt)
                        <tr class="book-tr">
                            <td class="book-td">{{$book_mgmt->book->name}}</td>
                            <td class="book-td">{{$book_mgmt->today_rest}}{{$book_mgmt->book->type->name}}</td>
                            <td class="book-td">
                                <form action="/today/{{$book_mgmt->book_id}}/exp" id="form_{{$book_mgmt->book_id}}_exp" method="post">
                                    @csrf
                                    <button type="button" class="btn-exp" onclick="exp({{$book_mgmt->book_id}})">期限切れ</button>
                                </form>
                            </td>
                            <td class="book-td">
                                <form action="/today/{{$book_mgmt->book_id}}/no_exp" id="form_{{$book_mgmt->book_id}}_no_exp" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" class="btn-no-exp" onclick="no_exp({{$book_mgmt->book_id}})">持ち越し</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <br>
            @endif

            @if(!$logs_exp->isEmpty())
            <h1 class="txt-h1">期限切れ</h1>
            <div class="logs">
                <table class="log-table">
                    <thead class="log-thead">
                        <tr>
                            <th class="log-th">参考書名</th>
                            <th class="log-th"></th>
                            <th class="log-th">予定日</th>
                            <th class="log-th"></th>
                            <th class="log-th"></th>
                        </tr>
                    </thead>
    
                    <tbody>
                    @foreach($logs_exp as $log)
                        <tr class="log-tr">
                            <td class="log-td">{{$log->book->name}}</td>
                            <td class="log-td">{{$log->book->type->name}}{{$log->number}}</td>
                            <td class="log-td">{{$log->scheduled_at}}</td>
                            <td class="log-td">
                                <form action="/today/{{$log->book_id}}/{{$log->number}}/comp_exp" id="form_{{$log->id}}_comp_exp" method="get">
                                    @csrf
                                    <button type="button" class="btn-comp" onclick="comp_exp({{$log->id}})">complete</button>
                                </form>
                            </td>
                            <td class="log-td">
                                <form action="/today/{{$log->book_id}}/{{$log->number}}/pass_exp" id="form_{{$log->id}}_pass_exp" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" class="btn-pass" onclick="pass_exp({{$log->id}})">pass</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
        
        <div class="today">
            <h1 class="txt-h1">Today {{\Carbon\Carbon::today()->format('Y/m/d')}}</h1>
            @foreach($books_today as $book_mgmt)
            <div class='book'>
                <h2 class="txt-h2"><a href="/books/{{$book_mgmt->book->id}}">{{$book_mgmt->book->name}}</a> 残り{{$book_mgmt->today_rest}}{{$book_mgmt->book->type->name}}</h2>
                <table class="book-table">
                    <tr>
                        @if ($book_mgmt->today_rest>0)
                        <td class="book-td">
                            {{$book_mgmt->book->type->name}}{{$book_mgmt->next}}
                        </td>
                        <td class="book-td">
                            <form action="/today/{{$book_mgmt->book_id}}/{{$book_mgmt->next}}/complete" id="form_{{$book_mgmt->book_id}}_complete" method="get">
                                @csrf
                                <button type="button" class="btn-comp" onclick="complete({{$book_mgmt->book_id}})">complete</button>
                            </form>
                        </td>
                        <td class="book-td">
                            <form action="/today/{{$book_mgmt->book_id}}/{{$book_mgmt->next}}/pass" id="form_{{$book_mgmt->book_id}}_pass" method="post">
                                @csrf
                                @method('PUT')
                                <button type="button" class="btn-pass" onclick="pass({{$book_mgmt->book_id}})">pass</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                </table>
            </div>
            @endforeach
        </div>

        <div class="tomorrow">
            <h1 class="txt-h1">Tommorow {{\Carbon\Carbon::tomorrow()->format('Y/m/d')}}</h1>
            @foreach($books_today as $book_mgmt)
                @if ($book_mgmt->intarval_id=='1' )
                <div class='book'>
                    <h2 class="txt-h2"><a href="/books/{{$book_mgmt->book->id}}">{{$book_mgmt->book->name}}</a> {{$book_mgmt->a_day}}{{$book_mgmt->book->type->name}}</h2>
                </div>
                @endif
            @endforeach
    
            @foreach($books_tomorrow as $book_mgmt)
                <div class='book'>
                    <h2 class="txt-h2"><a href="/books/{{$book_mgmt->book->id}}">{{$book_mgmt->book->name}}</a> 残り{{$book_mgmt->today_rest}}{{$book_mgmt->book->type->name}}</h2>
                    <table class="book-table">
                        <tr>
                            @if ($book_mgmt->today_rest!=0)
                            <td class="book-td">
                                {{$book_mgmt->book->type->name}}{{$book_mgmt->next}}
                            </td>
                            <td class="book-td">
                                <form action="/today/{{$book_mgmt->book_id}}/{{$book_mgmt->next}}/complete" id="form_{{$book_mgmt->book_id}}_complete" method="get">
                                    @csrf
                                    <button type="button" class="btn-comp" onclick="complete({{$book_mgmt->book_id}})">complete</button>
                                </form>
                            </td>
                            <td class="book-td">
                                <form action="/today/{{$book_mgmt->book_id}}/{{$book_mgmt->next}}/pass" id="form_{{$book_mgmt->book_id}}_pass" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" class="btn-pass" onclick="pass({{$book_mgmt->book_id}})">pass</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                    </table>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function exp(id){
            'use strict'
            if(confirm('期限切れにしますか？')){
                document.getElementById(`form_${id}_exp`).submit();
            }

        }
        function no_exp(id){
            'use strict'
            if(confirm('持ち越しますか？')){
                document.getElementById(`form_${id}_no_exp`).submit();
            }

        }
        function comp_exp(id){
            'use strict'
            if(confirm('完了しますか？')){
                document.getElementById(`form_${id}_comp_exp`).submit();
            }

        }
        function pass_exp(id){
            'use strict'

            if(confirm('本当にパスしますか？')){
                document.getElementById(`form_${id}_pass_exp`).submit();
            }
        }
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
            if(!@json($books_exp->isEmpty())){
                if(confirm('期限切れがあります。\n処理してください。')){

                }
            }
        }
    </script>
</body>
</html>
</x-app-layout>