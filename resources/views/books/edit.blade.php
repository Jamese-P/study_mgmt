<x-app-layout>
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <title>Book edit</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>

    <body>
        <div class="form1">
            <form action="/books/{{ $book_mgmt->book->id }}" method="POST" class="form-book">
                @csrf
                @method('PUT')
                <div class="form-element">
                    <label for="name" class="form-label">参考書名</label>
                    <input type="text" id="name" class="form-input" name="book[name]" placeholder="参考書名"
                        value="{{ $book_mgmt->book->name }}" />
                    <p class="name__error" style="color:red">{{ $errors->first('book.name') }}</p>
                </div>
                <div class="form-grid">
                    <div class="form-element">
                        <label for="subject" class="form-label">教科</label>
                        <select id="subject" class="form-select" name="book[subject_id]">
                            </option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" @if($subject->id === (int)old('book.subject_id',$book_mgmt->book->subject->id)) selected @endif>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-element">
                        <label for="type" class="form-label">単元またはページ</label>
                        <select id="type" class="form-select" name="book[type_id]">
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}" @if($type->id === (int)old('book.type_id',$book_mgmt->book->type->id)) selected @endif>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-element">
                        <input type="hidden" name="book[start]" value="{{ $book_mgmt->book->start }}">
                        <label for="next" class="form-label">次回学習単元またはページ</label>
                        <input id="next" class="form-number" type="number" name="book_mgmt[next]"
                            placeholder="最初の学習ページ" value="{{ $book_mgmt->next }}">
                        <p class="next__error" style="color:red">{{ $errors->first('book_mgmt.next') }}</p>
                    </div>
                    <div class="form-element">
                        <label for="max" class="form-label">終了単元またはページ</label>
                        <input id="max" class="form-number" type="number" name="book[max]" placeholder="終了ページ"
                            value="{{ $book_mgmt->book->max }}">
                        <p class="max__error" style="color:red">{{ $errors->first('book.max') }}</p>
                    </div>
                    <div class="form-element">
                        <label for="intarval" class="form-label">学習間隔</label>
                        <select id="intarval" class="form-select" name="book_mgmt[intarval_id]">
                            @foreach ($intarvals as $intarval)
                                <option value="{{ $intarval->id }}" @if($intarval->id === (int)old('book_mgmt.intarval_id',$book_mgmt->intarval->id)) selected @endif>{{ $intarval->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-element">
                        <label for="a_day" class="form-label">1日の学習単元またはページ</label>
                        <input id="a_day" class="form-number" type="number" name="book_mgmt[a_day]"
                            placeholder="1日の学習ページ" value="{{ $book_mgmt->a_day }}">
                        <p class="a_day__error" style="color:red">{{ $errors->first('book_mgmt.a_day') }}</p>
                    </div>
                </div>
                <div class="form-element">
                    <label for="next_learn_at" class="form-label">次回学習日</label>
                    <input id="next_learn_at" class="form-date" type="date" name="book_mgmt[next_learn_at]"
                        value="{{ $book_mgmt->next_learn_at }}">
                </div>
                <div class="back">
                    [<a href="{{ route('book.show', ['book' => $book_mgmt->book->id]) }}">back</a>]
                </div>
                <input type="submit" class="form-submit" value="保存" />
            </form>
        </div>

    </body>

    </html>
</x-app-layout>
