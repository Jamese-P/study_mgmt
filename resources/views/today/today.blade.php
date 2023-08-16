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
    
    @if(!$books_exp->isEmpty())
    <h1>期限切れの参考書</h1>
    <div class="books">
        <table>
            <tr>
                <th>参考書名</th>
                <th>残り</th>
                <th></th>
                <th></th>
            </tr>
            @foreach($books_exp as $book_mgmt)
            <tr>
                <th>{{$book_mgmt->book->name}}</th>
                <th>{{$book_mgmt->today_rest}}{{$book_mgmt->book->type->name}}</th>
                <th>
                    <form action="/today/{{$book_mgmt->book_id}}/exp" id="form_{{$book_mgmt->book_id}}_exp" method="post">
                        @csrf
                        <button type="button" onclick="exp({{$book_mgmt->book_id}})">期限切れ</button>
                    </form>
                </th>
                <th>
                    <form action="/today/{{$book_mgmt->book_id}}/no_exp" id="form_{{$book_mgmt->book_id}}_no_exp" method="post">
                        @csrf
                        @method('PUT')
                        <button type="button" onclick="no_exp({{$book_mgmt->book_id}})">持ち越し</button>
                    </form>
                </th>
            </tr>
            
            @endforeach
        </table>
    </div>
    @endif
    
    <br>
    
    @if(!$logs_exp->isEmpty())
    <h1>期限切れ</h1>
    <div class="logs">
        <table>
            <tr>
                <th>参考書名</th>
                <th></th>
                <th>予定日</th>
                <th></th>
                <th></th>
                
            </tr>
        @foreach($logs_exp as $log)
            <tr>
                <th>{{$log->book->name}}</th>
                <th>{{$log->book->type->name}}{{$log->number}}</th>
                <th>{{$log->scheduled_at}}</th>
                <th>
                    <form action="/today/{{$log->book_id}}/{{$log->number}}/comp_exp" id="form_{{$log->id}}_comp_exp" method="get">
                        @csrf
                        <button type="button" onclick="comp_exp({{$log->id}})">complete</button>
                    </form>
                </th>
                <th>
                    <form action="/today/{{$log->book_id}}/{{$log->number}}/pass_exp" id="form_{{$log->id}}_pass_exp" method="post">
                        @csrf
                        @method('PUT')
                        <button type="button" onclick="pass_exp({{$log->id}})">pass</button>
                    </form>
                </th>
            </tr>
        @endforeach
        </table>
    </div>
    @endif
    
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
            @if ($book_mgmt->intarval_id=='1' )
            <div class='book'>
                <h2><a href="/books/{{$book_mgmt->book->id}}">{{$book_mgmt->book->name}}</a> {{$book_mgmt->a_day}}{{$book_mgmt->book->type->name}}</h2>
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