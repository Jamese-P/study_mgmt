<x-app-layout>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Book</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <div class="form1">
            <form action="/books" method="POST" class="form-book">
                @csrf
                <div class="form-element">
                    <label for="name" class="form-label">参考書名</label>
                    <input type="text" name="book[name]" id="name" class="form-input" placeholder="参考書名" value="{{old('book.name')}}"/>
                    <p class="name__error" style="color:red">{{ $errors->first('book.name') }}</p>
                </div>
                <div class="form-grid">
                    <div class="form-element">
                        <label for="subject" class="form-label">教科</label>
                        <select id="subject" class="form-select" name="book[subject_id]">
                            @foreach($subjects as $subject)
                                <option value="{{$subject->id}}">{{$subject->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-element">
                        <label for="type" class="form-label">単元またはページ</label>
                        <select id="type" class="form-select" name="book[type_id]">
                            @foreach($types as $type)
                                <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-element">
                        <label for="start" class="form-label">初回学習単元またはページ</label>
                        <input id="start" class="form-number" type="number" name="book[start]" placeholder="開始ページ" value="{{old('book.start',1)}}">
                        <p class="next__error" style="color:red">{{ $errors->first('book.start') }}</p>
                        <input type="hidden" name="book_mgmt[next]" value="{{old('book.start',1)}}">
                    </div>
                    <div class="form-element">
                        <label for="finish" class="form-label">終了単元またはページ</label>
                        <input type="number" id="finish" class="form-number" name="book[max]" placeholder="終了ページ" value="{{old('book.max')}}">
                        <p class="max__error" style="color:red">{{ $errors->first('book.max') }}</p>
                    </div>
                    <div class="form-element">
                        <label for="intarval" class="form-label">学習間隔</label>
                        <select id="intarval" class="form-select" name="book_mgmt[intarval_id]">
                            @foreach($intarvals as $intarval)
                                <option value="{{$intarval->id}}">{{$intarval->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-element">
                        <label for="a_day" class="form-label">1日の学習単元またはページ</label>
                        <input type="number" id="a_day" class="form-number" name="book_mgmt[a_day]" placeholder="1日の学習ページ" value="{{old('book_mgmt.a_day')}}">
                        <p class="a_day__error" style="color:red">{{ $errors->first('book_mgmt.a_day') }}</p>
                    </div>
                </div>
                <div class="form-element">
                    <label for="next_learn_at" class="form-label">初回学習日</label>
                    <input type="date" id="next_learn_at" class="form-date" name="book_mgmt[next_learn_at]" value="{{old('book_mgmt.next_learn_at',\Carbon\Carbon::today()->format('Y-m-d'))}}">
                    <p class="next_learn_at__error" style="color:red">{{ $errors->first('book_mgmt.next_learn_at') }}</p>
                </div>
                <div class="back">
                    [<a href="{{route('today')}}">back</a>]
                </div>
                <input type="submit" class="form-submit" value="保存"/>
            </form>
        </div>
        
    </body>
</html>
</x-app-layout>