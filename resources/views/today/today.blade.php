<x-app-layout>
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
    @if(!$books_exp->isEmpty())
    <div class="flex justify-centeritems-center p-4 mb-4 text-sm text-red-600 border border-red-600 rounded-lg bg-red-50 dark:text-red-400 dark:border-red-400" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Danger alert!</span> 期限切れの参考書を処理してください
            </div>
    </div>
    @endif
    
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
                            <td class="book-td"><a href="{{route('book.show',['book'=>$book_mgmt->book_id])}}">{{$book_mgmt->book->name}}</a></td>
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
                            <td class="log-td"><a href="{{route('book.show',['book'=>$log->book_id])}}">{{$log->book->name}}</a></td>
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
            <h1 class="txt-h1">Today <div class="text-base flex place-items-end">{{\Carbon\Carbon::today()->format('Y/m/d')}}</div></h1>
            <table>
                <tbody>
                    @foreach($books_today as $book_mgmt)
                    <div class='book'>
                        <tr class="book-thead">
                            <td>
                                <h2 class="txt-book-name"><a href="/books/{{$book_mgmt->book->id}}">{{$book_mgmt->book->name}}</a></h2>
                            </td>
                            <td>
                                残り{{$book_mgmt->today_rest}}{{$book_mgmt->book->type->name}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
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
                            </td>
                        </tr>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="tomorrow">
            <h1 class="txt-h1">Tommorow  <div class="text-base flex place-items-end">{{\Carbon\Carbon::tomorrow()->format('Y/m/d')}}</div></h1>
            <table>
                <tbody>
                    @foreach($books_tomorrow as $book_mgmt)
                    <div class='book'>
                        <tr class="book-thead">
                            <td>
                                <h2 class="txt-book-name"><a href="/books/{{$book_mgmt->book->id}}">{{$book_mgmt->book->name}}</a></h2>
                            </td>
                            <td>
                                残り{{$book_mgmt->today_rest}}{{$book_mgmt->book->type->name}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
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
                            </td>
                        </tr>
                    </div>
                    @endforeach
                    
                    @foreach($books_today as $book_mgmt)
                        @if ($book_mgmt->intarval_id=='1' )
                        <tr class="book-thead">
                            <td>
                                <h2 class="txt-book-name"><a href="/books/{{$book_mgmt->book->id}}">{{$book_mgmt->book->name}}</a></h2>
                            </td>
                            <td>
                                {{$book_mgmt->a_day}}{{$book_mgmt->book->type->name}}
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
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