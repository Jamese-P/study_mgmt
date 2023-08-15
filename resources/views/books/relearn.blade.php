<x-app-layout>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>再学習</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <form action="/books/{{$book->id}}/relearn" method="POST">
            @csrf
            @method('PUT')
            <div class="name">
                <h2>{{$book->name}}</h2>
            </div>
            <div class="subject">
                <h2>{{$book->subject->name}}</h2>
            </div>
            <div class="max">
                <h2>終了{{$book->type->name}}：{{$book->max}}</h2>
            </div>
            <div class="a_day">
                <h2>1日の学習単元またはページ</h2>
                <input type="number" name="book_mgmt[a_day]" placeholder="1日の学習ページ" value="{{old('book_mgmt.a_day')}}">
                <p class="a_day__error" style="color:red">{{ $errors->first('book_mgmt.a_day') }}</p>
            </div>
            <div class="comprehension">
                <h2>学習対象単元の理解度</h2>
                <select name="comprehension_id">
                    @foreach($comprehensions as $comprehension)
                        <option value="{{$comprehension->id}}">{{$comprehension->name}}</option>
                    @endforeach
                </select>未満
            </div>
            <div class="intarval">
                <h2>学習間隔</h2>
                <select name="book_mgmt[intarval_id]">
                    @foreach($intarvals as $intarval)
                        <option value="{{$intarval->id}}">{{$intarval->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="next_learn_at">
                <h2>学習日</h2>
                <input type="date" name="book_mgmt[next_learn_at]" value="{{old('book_mgmt.next_learn_at')}}">
                <p class="next_learn_at__error" style="color:red">{{ $errors->first('book_mgmt.next_learn_at') }}</p>
            </div>
            <input type="submit" value="保存"/>
        </form>
        <div class="back">
            [<a href="{{route('book.index')}}">back</a>]
        </div>
    </body>
</html>
</x-app-layout>