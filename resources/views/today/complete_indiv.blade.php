<x-app-layout>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Complete</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <form action="{{route('today.comp_indiv_log')}}" method="POST">
            @csrf
            <div class="name">
                <h1>参考書名</h1>
                <select name="log[book_id]">
                    @foreach($books as $book)
                        <option value="{{$book->id}}">{{$book->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="number">
                <h2>単元またはページ</h2>
                <input type="number" name="log[number]" placeholder="学習ページ" value="{{old('log.number')}}">
                <p class="number__error" style="color:red">{{ $errors->first('log.number') }}</p>
            </div>
            <div class="comprehension">
                <h2>理解度</h2>
                <select name="log[comprehension_id]">
                    @foreach($comprehensions as $comprehension)
                        <option value="{{$comprehension->id}}">{{$comprehension->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="comment">
                <h2>コメント</h2>
                <textarea name="log[comment]" placeholder="コメント" value="{{old('log.comment')}}"></textarea>
            </div>
            
            <input type="submit" value="保存"/>
        </form>
            
        <div class="back">
            [<a href="{{route('today')}}">back</a>]
        </div>
    </body>
</html>
</x-app-layout>