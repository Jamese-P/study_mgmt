    <x-app-layout>
        @if (!$books_exp->isEmpty())
            <div class="flex justify-centeritems-center p-4 mb-4 text-sm text-red-600 border border-red-600 rounded-lg bg-red-50 dark:text-red-400 dark:border-red-400"
                role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Danger alert!</span> 期限切れの参考書を処理してください
                </div>
            </div>
        @endif


        <div class="exp">
            @if (!$books_exp->isEmpty())
                <h1 class="txt-h1">期限切れの参考書</h1>
                <div class="books">
                    <table class="book-table">
                        <thead class="book-thead">
                            <tr>
                                <th class="book-th">参考書名</th>
                                <th class="book-th">予定日</th>
                                <th class="book-th">残り</th>
                                <th class="book-th"></th>
                                <th class="book-th"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($books_exp as $book_mgmt)
                                <tr class="book-tr">
                                    <td class="book-td"><a class="link"
                                            href="{{ route('book.show', ['book' => $book_mgmt->book_id]) }}">{{ $book_mgmt->book->name }}</a>
                                    </td>
                                    <td class="book-td">
                                        {{ $book_mgmt->next_learn_at }}
                                    </td>
                                    <td class="book-td">
                                        {{ $book_mgmt->today_rest }}{{ $book_mgmt->book->type->name }}
                                    </td>
                                    <td class="book-td">
                                        <form action="/today/{{ $book_mgmt->book_id }}/exp"
                                            id="form_{{ $book_mgmt->book_id }}_exp" method="post">
                                            @csrf
                                            <button type="button" class="btn-exp"
                                                onclick="exp({{ $book_mgmt->book_id }})">期限切れ</button>
                                        </form>
                                    </td>
                                    <td class="book-td">
                                        <form action="/today/{{ $book_mgmt->book_id }}/no_exp"
                                            id="form_{{ $book_mgmt->book_id }}_no_exp" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button type="button" class="btn-no-exp"
                                                onclick="no_exp({{ $book_mgmt->book_id }})">持ち越し</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <br>
            @endif

            @if (!$logs_exp->isEmpty())
                <h1 class="txt-h1">期限切れ</h1>
                <div class="logs">
                    <div>
                        <table class="log-table">
                            <thead class="log-thead">
                                <tr>
                                    <th class="log-th">参考書名</th>
                                    <th class="log-th"></th>
                                    <th class="log-th">予定日</th>
                                    <th class="log-th"></th>
                                    <th class="log-th"></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($logs_exp as $log)
                                    <tr class="log-tr">
                                        <td class="log-td"><a class="link"
                                                href="{{ route('book.show', ['book' => $log->book_id]) }}">{{ $log->book->name }}</a>
                                        </td>
                                        <td class="log-td">{{ $log->book->type->name }}{{ $log->number }}</td>
                                        <td class="log-td">{{ $log->scheduled_at }}</td>
                                        <td class="log-td">
                                            <button type="button" class="btn-comp"
                                                onclick="comp_exp({{ $log->id }})">complete</button>
                                        </td>
                                        <td class="log-td">
                                            <form action="/today/{{ $log->book_id }}/{{ $log->number }}/pass_exp"
                                                id="form_{{ $log->id }}_pass_exp" method="post">
                                                @csrf
                                                @method('PUT')
                                                <button type="button" class="btn-pass"
                                                    onclick="pass_exp({{ $log->id }})">pass</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <div id="modal-comp-exp_{{ $log->id }}" class="modal-layer">
                                        <div class="modal">
                                            <div class="modal-inner">
                                                <button type="button" class="modal-btn-close"
                                                    onclick="closeCompExpModal({{ $log->id }})">
                                                    <svg class="h-3 w-3" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                                <div class="px-6 py-6 lg:px-8">
                                                    <h3 class="modal-title">学習登録</h3>
                                                    <form action="{{ route('today.comp_exp') }}" method="POST"
                                                        class="form-log">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-element">
                                                            <div class="name">
                                                                <h1 class="txt-h2">{{ $log->book->name }}
                                                                    {{ $log->book->type->name }}{{ $log->number }}
                                                                </h1>
                                                            </div>
                                                        </div>
                                                        <p class="text-right">予定日：{{ $log->scheduled_at }}</p>
                                                        <input type="hidden" name="log[book_id]"
                                                            value="{{ $log->book->id }}">
                                                        <input type="hidden" name="log[number]"
                                                            value="{{ $log->number }}">
                                                        <div class="form-element">
                                                            <div class="comprehension">
                                                                <label for="comprehension"
                                                                    class="form-label">理解度</label>
                                                                <select id="comprehension" class="form-select" name="log[comprehension_id]"  required>
                                                                    <option value="" selected>選択してください</option>
                                                                    @foreach ($comprehensions as $comprehension)
                                                                        <option value="{{ $comprehension->id }}"
                                                                            @if ($comprehension->id === (int) old('log.comprehension_id')) selected @endif>
                                                                            {{ $comprehension->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <p class="comprehension_id__error" style="color:red">{{ $errors->first('log.comprehension_id') }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="form-element">
                                                            <div class="comment">
                                                                <label for="comment" class="form-label">コメント</label>
                                                                <textarea id="comment" class="form-textarea" name="log[comment]" placeholder="コメント">{{ old('log.comment') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-element">
                                                            <input type="submit" class="form-submit"
                                                                value="保存" />
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
        <div class="grid2">
            <div class="today w-fit">
                <h1 class="txt-h1">Today <div class="text-base flex place-items-end">
                        {{ \Carbon\Carbon::today()->format('Y/m/d') }}</div>
                </h1>
                <table class="logs">
                    <tbody>
                        @foreach ($books_today as $book_mgmt)
                            <div class='book'>
                                <tr class="book-thead">
                                    <td>
                                        <h2 class="txt-book-name"><a class="link"
                                                href="/books/{{ $book_mgmt->book->id }}">{{ $book_mgmt->book->name }}</a>
                                        </h2>
                                    </td>
                                    <td>
                                        残り{{ $book_mgmt->today_rest }}{{ $book_mgmt->book->type->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="book-table">
                                            <tr>
                                                @if ($book_mgmt->today_rest > 0)
                                                    <td class="book-td">
                                                        {{ $book_mgmt->book->type->name }}{{ $book_mgmt->next }}
                                                    </td>
                                                    <td class="book-td">
                                                        <button type="button" class="btn-comp"
                                                            onclick="complete({{ $book_mgmt->book_id }})">complete</button>
                                                    </td>
                                                    <td class="book-td">
                                                        <form
                                                            action="/today/{{ $book_mgmt->book_id }}/{{ $book_mgmt->next }}/pass"
                                                            id="form_{{ $book_mgmt->book_id }}_pass" method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="button" class="btn-pass"
                                                                onclick="pass({{ $book_mgmt->book_id }})">pass</button>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </div>

                            <div id="modal-comp_{{ $book_mgmt->book_id }}" class="modal-layer">
                                <div class="modal">
                                    <div class="modal-inner">
                                        <button type="button" class="modal-btn-close"
                                            onclick="closeCompModal({{ $book_mgmt->book_id }})">
                                            <svg class="h-3 w-3" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="px-6 py-6 lg:px-8">
                                            <h3 class="modal-title">学習登録</h3>
                                            <div class="">
                                                <form action="{{ route('today.comp') }}" method="POST"
                                                    class="form-log">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="log[book_id]"
                                                        value="{{ $book_mgmt->book_id }}">
                                                    <input type="hidden" name="log[number]"
                                                        value="{{ $book_mgmt->next }}">
                                                    <div class="form-element">
                                                        <div class="name">
                                                            <h1 class="txt-h2">{{ $book_mgmt->book->name }}
                                                                {{ $book_mgmt->book->type->name }}{{ $book_mgmt->next }}
                                                            </h1>
                                                        </div>
                                                    </div>
                                                    <div class="form-element">
                                                        <div class="comprehension">
                                                            <label for="comprehension" class="form-label">理解度</label>
                                                            <select id="comprehension" class="form-select"
                                                                name="log[comprehension_id]" required>
                                                                <option value="" selected>選択してください</option>
                                                                @foreach ($comprehensions as $comprehension)
                                                                    <option value="{{ $comprehension->id }}"
                                                                        @if ($comprehension->id === (int) old('log.comprehension_id')) selected @endif>
                                                                        {{ $comprehension->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <p class="comprehension_id__error" style="color:red">{{ $errors->first('log.comprehension_id') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-element">
                                                        <div class="comment">
                                                            <label for="comment" class="form-label">コメント</label>
                                                            <textarea id="comment" class="form-textarea" name="log[comment]" placeholder="コメント">{{ old('log.comment') }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-element">
                                                        <input type="submit" class="form-submit" value="保存" />
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>

            </div>

            <div class="tomorrow w-fit">
                <h1 class="txt-h1">Tommorow <div class="text-base flex place-items-end">
                        {{ \Carbon\Carbon::tomorrow()->format('Y/m/d') }}</div>
                </h1>
                <table class="logs">
                    <tbody>
                        @foreach ($books_tomorrow as $book_mgmt)
                            <div class='book'>
                                <tr class="book-thead">
                                    <td>
                                        <h2 class="txt-book-name"><a class="link"
                                                href="/books/{{ $book_mgmt->book->id }}">{{ $book_mgmt->book->name }}</a>
                                        </h2>
                                    </td>
                                    <td>
                                        残り{{ $book_mgmt->today_rest }}{{ $book_mgmt->book->type->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="book-table">
                                            <tr>
                                                @if ($book_mgmt->today_rest != 0)
                                                    <td class="book-td">
                                                        {{ $book_mgmt->book->type->name }}{{ $book_mgmt->next }}
                                                    </td>
                                                    <td class="book-td">
                                                        <button type="button" class="btn-comp"
                                                            onclick="complete({{ $book_mgmt->book_id }})">complete</button>
                                                    </td>
                                                    <td class="book-td">
                                                        <form
                                                            action="/today/{{ $book_mgmt->book_id }}/{{ $book_mgmt->next }}/pass"
                                                            id="form_{{ $book_mgmt->book_id }}_pass" method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="button" class="btn-pass"
                                                                onclick="pass({{ $book_mgmt->book_id }})">pass</button>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </div>
                            <div id="modal-comp_{{ $book_mgmt->book_id }}" class="modal-layer">
                                <div class="modal">
                                    <div class="modal-inner">
                                        <button type="button" class="modal-btn-close"
                                            onclick="closeCompModal({{ $book_mgmt->book_id }})">
                                            <svg class="h-3 w-3" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="px-6 py-6 lg:px-8">
                                            <h3 class="modal-title">学習登録</h3>
                                            <div class="">
                                                <form action="{{ route('today.comp') }}" method="POST"
                                                    class="form-log">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="log[book_id]"
                                                        value="{{ $book_mgmt->book_id }}">
                                                    <input type="hidden" name="log[number]"
                                                        value="{{ $book_mgmt->next }}">
                                                    <div class="form-element">
                                                        <div class="name">
                                                            <h1 class="txt-h2">{{ $book_mgmt->book->name }}
                                                                {{ $book_mgmt->book->type->name }}{{ $book_mgmt->next }}
                                                            </h1>
                                                        </div>
                                                    </div>
                                                    <div class="form-element">
                                                        <div class="comprehension">
                                                            <label for="comprehension" class="form-label">理解度</label>
                                                            <select id="comprehension" class="form-select"
                                                                name="log[comprehension_id]" required>
                                                                <option value="" selected>選択してください</option>
                                                                @foreach ($comprehensions as $comprehension)
                                                                    <option value="{{ $comprehension->id }}"
                                                                        @if ($comprehension->id === (int) old('log.comprehension_id')) selected @endif>
                                                                        {{ $comprehension->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <p class="comprehension_id__error" style="color:red">{{ $errors->first('log.comprehension_id') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-element">
                                                        <div class="comment">
                                                            <label for="comment" class="form-label">コメント</label>
                                                            <textarea id="comment" class="form-textarea" name="log[comment]" placeholder="コメント">{{ old('log.comment') }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-element">
                                                        <input type="submit" class="form-submit" value="保存" />
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @foreach ($books_today as $book_mgmt)
                            @if ($book_mgmt->intarval_id == '1')
                                <tr class="book-thead">
                                    <td>
                                        <h2 class="txt-book-name"><a class="link"
                                                href="/books/{{ $book_mgmt->book->id }}">{{ $book_mgmt->book->name }}</a>
                                        </h2>
                                    </td>
                                    <td>
                                        {{ $book_mgmt->a_day }}{{ $book_mgmt->book->type->name }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            window.onload = function() {
                if (!@json($books_exp->isEmpty())) {
                    if (confirm('期限切れがあります。\n処理してください。')) {

                    }
                }
            }

            function exp(id) {
                'use strict'
                if (confirm('期限切れにしますか？')) {
                    document.getElementById(`form_${id}_exp`).submit();
                }

            }

            function no_exp(id) {
                'use strict'
                if (confirm('持ち越しますか？')) {
                    document.getElementById(`form_${id}_no_exp`).submit();
                }

            }

            function pass_exp(id) {
                'use strict'

                if (confirm('本当にパスしますか？')) {
                    document.getElementById(`form_${id}_pass_exp`).submit();
                }
            }

            function pass(id) {
                'use strict'

                if (confirm('本当にパスしますか？')) {
                    document.getElementById(`form_${id}_pass`).submit();
                }
            }

            function comp_exp(id) {
                document.getElementById(`modal-comp-exp_${id}`).style.display = 'flex';

            }

            function complete(id) {
                document.getElementById(`modal-comp_${id}`).style.display = 'flex';
            }

            window.closeCompModal = function(id) {
                document.getElementById(`modal-comp_${id}`).style.display = 'none';
            }

            window.closeCompExpModal = function(id) {
                document.getElementById(`modal-comp-exp_${id}`).style.display = 'none';
            }

            window.closeExpBooksModal = function() {
                document.getElementById('modal-exp-books').style.display = 'none';
            }
        </script>
    </x-app-layout>
