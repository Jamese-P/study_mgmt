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
        <div class="form1">
            <form action="{{ route('today.comp_indiv_log') }}" method="POST" class="form-log">
                @csrf
                <div class="form-element">
                    <div class="name">
                        <label for="book" class="form-label">参考書名</label>
                        <select id="book" name="log[book_id]" class="form-select">
                            @foreach ($books as $book)
                                <option value="{{ $book->id }}">{{ $book->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-element">
                    <div class="number">
                        <label for="number" class="form-label">単元またはページ</label>
                        <input type="number" id="number" name="log[number]" class="form-number" placeholder="学習ページ"
                            value="{{ old('log.number') }}">
                        <p class="number__error" style="color:red">{{ $errors->first('log.number') }}</p>
                    </div>
                </div>
                <div class="form-element">
                    <div class="comprehension">
                        <label for="comprehension" class="form-label">理解度</label>
                        <select id="comprehension" class="form-select" name="log[comprehension_id]">
                            @foreach ($comprehensions as $comprehension)
                                <option value="{{ $comprehension->id }}">{{ $comprehension->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-element">
                    <div class="comment">
                        <label for="comment" class="form-label">コメント</label>
                        <textarea id="comment" class="form-textarea" name="log[comment]" placeholder="コメント" value="{{ old('log.comment') }}"></textarea>
                    </div>
                </div>
                <div class="form-element">
                    <input type="submit" class="form-submit" value="保存" />
                </div>
            </form>
        </div>


    </body>

    </html>
</x-app-layout>
