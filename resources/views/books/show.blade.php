<x-app-layout>
    <x-slot name="header">
        {{ $book_mgmt->book->name }}<a href="/books/{{ $book_mgmt->book->id }}/edit" class="btn-comp">edit</a>
    </x-slot>
    <!DOCTYPE HTML>
    <html lang="{{ str_replace('_', '_', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Book</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>

    <body>
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
    </body>

    </html>
</x-app-layout>
