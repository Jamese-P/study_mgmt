<x-app-layout>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Logs</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div>
        <p class="log-head">表示させる教科を選択してください</p>
        <div class="subject">
        @foreach($subjects as $subject)
            <input type="checkbox" id="subject{{$subject->id}}" name="subjects" value="{{$subject->id}}" onchange="func_subject()" checked>
            <label class="subject-label" for="subject{{$subject->id}}">{{$subject->name}}</label>
        @endforeach
        </div>

    </div>
    
    <div class='logs'>
        <table class="log-table">
            <thead class="log-thead">
                <tr>
                    <th class="log-th" scope="col">@sortablelink('subject', '教科')</th>
                    <th class="log-th" scope="col">参考書名</th>
                    <th class="log-th" scope="col"></th>
                    <th class="log-th" scope="col">@sortablelink('learned_at', '学習日')</th>
                    <th class="log-th" scope="col">@sortablelink('comprehension_id', '理解度')</th>
                    <th class="log-th">コメント</th>
                </tr>
            </thead>
            <tbody>
            @foreach($logs as $log)
                <tr class="log-tr">
                    <td class="log-td">{{$log->book->subject->name}}</td>
                    <td class="log-td"><a class="link" href="/books/{{$log->book->id}}">{{$log->book->name}}</a></td>
                    <td class="log-td">{{$log->book->type->name}}{{$log->number}}</td>
                    <td class="log-td">{{$log->learned_at}}</td>
                    <td class="log-td">{{$log->comprehension->name}}</td>
                    <td class="log-td">{{$log->comment}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>
            {{$logs->appends(request()->query())->links()}}
        </div>
    </div>
    <script>
        
        
        function func_subject(){
            var val=[];
            let input_subjects = document.querySelectorAll("input[name=subjects]:checked");
            if( 0 < input_subjects.length ) {
	            for(let checked_data of input_subjects) {
		            val.push(checked_data.value); 
	            }
	            console.log(val);
            }
        }
    </script>
</body>
</html>
</x-app-layout>