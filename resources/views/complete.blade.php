<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Complete</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <form action="/today/{{$book->id}}/{{$unit}}" method="POST">
            @csrf
            <div class="name">
                <h1>{{$book->name}} {{$book->type->name}}{{$unit}}</h1>
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
            [<a href="/">back</a>]
        </div>
    </body>
</html>