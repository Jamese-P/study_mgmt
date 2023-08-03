<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Book</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <form action="/books/{{$book->id}}" method="POST">
            @csrf
            @method('PUT')
            <div class="name">
                <h2>参考書名</h2>
                <input type="text" name="book[name]" placeholder="参考書名" value="{{$book->name}}"/>
                <p class="name__error" style="color:red">{{ $errors->first('book.name') }}</p>
            </div>
            <div class="subject">
                <h2>教科</h2>
                <select name="book[subject_id]">
                    <option value="{{$book->subject->id}}">{{$book->subject->name}}</option>
                    @foreach($subjects as $subject)
                        <option value="{{$subject->id}}">{{$subject->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="type">
                <h2>単元またはページ</h2>
                <select name="book[type_id]">
                    <option value="{{$book->type->id}}">{{$book->type->name}}</option>
                    @foreach($types as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="max">
                <h2>終了単元またはページ</h2>
                <input type="number" name="book[max]" placeholder="終了ページ" value="{{$book->max}}">
                <p class="max__error" style="color:red">{{ $errors->first('book.max') }}</p>
            </div>
            <div class="a_day">
                <h2>1日の学習単元またはページ</h2>
                <input type="number" name="book[a_day]" placeholder="1日の学習ページ" value="{{$book->a_day}}">
                <p class="a_day__error" style="color:red">{{ $errors->first('book.a_day') }}</p>
            </div>
            <div class="intarval">
                <h2>学習間隔</h2>
                <select name="book[intarval_id]">
                    <option value="{{$book->intarval->id}}">{{$book->intarval->name}}</option>
                    @foreach($intarvals as $intarval)
                        <option value="{{$intarval->id}}">{{$intarval->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="next_learn_at">
                <h2>学習日</h2>
                <input type="date" name="book[next_learn_at]" value="{{$book->next_learn_at}}">
            </div>
            <input type="submit" value="保存"/>
        </form>
        <div class="back">
            [<a href="/">back</a>]
        </div>
    </body>
</html>