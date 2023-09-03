<x-app-layout>
    <x-slot name="header">
        再学習
    </x-slot>
        <div class="form1">
            <form action="/books/{{ $book->id }}/relearn" method="POST" class="form-book">
                @csrf
                @method('PUT')
                <div class="form-element">
                    <h1 class="txt-h1">{{ $book_mgmt->book->name }}</h1>
                    <input type="hidden" name="book[name]" value="{{ $book_mgmt->book->name }}">
                </div>
                <div class="form-element">
                    <h2 class="txt-h2">{{ $book_mgmt->book->subject->name }}</h2>
                </div>
                <div class="form-grid">
                    <input type="hidden" name="book[start]" value="{{ $book_mgmt->book->start }}">
                    <input type="hidden" name="book[max]" value="{{ $book_mgmt->book->max }}">
                    <div class="form-element">
                        <label for="next" class="form-label">開始{{ $book_mgmt->book->type->name }}</label>
                        <input type="number" id="next" class="form-input" name="book_mgmt[next]"
                            placeholder="開始{{ $book->type->name }}" value="{{ old('book_mgmt.next', $book->start) }}">
                    </div>
                    <div class="form-element">
                        <label for="finish" class="form-label">終了{{ $book->type->name }}</label>
                        <input type="number" id="finish" class="form-input" name="book_mgmt[finish]"
                            placeholder="開始{{ $book->type->name }}" value="{{ old('book.max', $book->max) }}" required>
                    </div>
                </div>

                <div class="form-element">
                    <label for="comprehension" class="form-label">学習対象単元の理解度(未満)</label>
                    <select name="comprehension_id" class="form-select">
                        @foreach ($comprehensions as $comprehension)
                            <option value="{{ $comprehension->id }}">{{ $comprehension->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-grid">
                    <div class="form-element">
                        <label for="intarval" class="form-label">学習間隔</label>
                        <select id="intarval" class="form-select" name="book_mgmt[intarval_id]">
                            <option value="{{ $book_mgmt->intarval->id }}">{{ $book_mgmt->intarval->name }}</option>
                            @foreach ($intarvals as $intarval)
                                <option value="{{ $intarval->id }}">{{ $intarval->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-element">
                        <label for="a_day" class="form-label">1回の学習{{ $book->type->name }}</label>
                        <input id="a_day" class="form-input" type="number" name="book_mgmt[a_day]"
                            placeholder="1日の学習{{ $book->type->name }}"
                            value="{{ old('book_mgmt.a_day', $book_mgmt->a_day) }}">
                        <p class="a_day__error" style="color:red">{{ $errors->first('book_mgmt.a_day') }}</p>
                    </div>
                </div>

                <div class="form-element">
                    <label for="next_learn_at" class="form-label">学習日</label>
                    <input id="next_learn_at" class="form-date" type="date" name="book_mgmt[next_learn_at]"
                        value="{{ old('book_mgmt.next_learn_at', \Carbon\Carbon::today()->format('Y-m-d')) }}">
                    <p class="next_learn_at__error" style="color:red">{{ $errors->first('book_mgmt.next_learn_at') }}
                    </p>
                </div>
                <div class="back">
                    [<a href="{{ route('book.index') }}">back</a>]
                </div>
                <input type="submit" class="form-submit" value="保存" />
            </form>
        </div>
</x-app-layout>
