<x-app-layout>
    <x-slot name="header">
        {{ $book_mgmt->book->name }}
        <a href="/books/{{ $book_mgmt->book->id }}/edit" class="btn-comp">edit</a>
        
    </x-slot>
        <table class="book-table">
            <thead class="book-thead">
                <tr>
                    <th class="book-th"></th>
                    <th class="book-th">進捗</th>
                    <th class="book-th">学習スピード</th>
                    <th class="book-th">次回</th>
                    <th class="book-th">終了</th>
                    <th class="book-th"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="book-td">{{ $book_mgmt->book->subject->name }}</td>
                    <td class="book-td">{{ $book_mgmt->percent }}%</td>
                    <td class="book-td">
                        {{ $book_mgmt->intarval->name }}{{ $book_mgmt->a_day }}{{ $book_mgmt->book->type->name }}</td>
                    <td class="book-td">
                        {{ $book_mgmt->next_learn_at }}<br>{{ $book_mgmt->book->type->name }}{{ $book_mgmt->next }}
                    </td>
                    <td class="book-td">
                        {{ $book_mgmt->end_date }}<br>{{ $book_mgmt->book->type->name }}{{ $book_mgmt->book->max }}
                    </td>

                </tr>
            </tbody>
        </table>

        <br>
        <form method="POST" action="{{ route('book.destroy', ['book'=>$book_mgmt->book_id]) }}" id="form_destroy">
            @csrf
            @method('DELETE')
            <button type="button" class="btn-pass" onclick="destroy()" >delete</button>
        </form>
        <br>

        <div class="w-fit">
            <h2 class="txt-h2">学習履歴</h2>
            <div class='logs'>
                <table class="log-table">
                    <thead class="log-thead">
                        <tr>
                            <th class="log-th">{{ $book_mgmt->book->type->name }}</th>
                            <th class="log-th">学習日時</th>
                            <th class="log-th">理解度</th>
                            <th class="log-th">コメント</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr class="log-tr">
                                <td class="log-td">{{ $log->number }}</td>
                                <td class="log-td">{{ $log->learned_at }}</td>
                                <td class="log-td">{{ $log->comprehension->name }}</td>
                                <td class="log-td">{{ $log->comment }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            function destroy() {
                'use strict'
                if (confirm('本当に削除しますか？')) {
                    document.getElementById(`form_destroy`).submit();
                }

            }
        </script>
</x-app-layout>
