<x-app-layout>
        <div class="hidden" id='calendar'></div>
        <div>
            <form action="{{ route('log.index.refine') }}" method="GET">
                <p class="log-head">表示させる教科を選択してください</p>
                <div class="subject">
                    @foreach ($subjects as $subject)
                        @if (in_array($subject->id, $display_subjects))
                            <input type="checkbox" id="subject{{ $subject->id }}" name="subject[{{ $subject->id }}]"
                                value="{{ $subject->id }}" checked />
                        @else
                            <input type="checkbox" id="subject{{ $subject->id }}" name="subject[{{ $subject->id }}]"
                                value="{{ $subject->id }}" />
                        @endif
                        <label class="subject-label" for="subject{{ $subject->id }}">{{ $subject->name }}</label>
                    @endforeach
                    <input type="submit" class="btn-exp" value="絞り込み" />
                </div>
            </form>
        </div>

        <div class='logs'>
            <table class="log-table">
                <thead class="log-thead">
                    <tr>
                        <th class="log-th" scope="col">@sortablelink('subject', '教科')</th>
                        <th class="log-th" scope="col">@sortablelink('book_id', '参考書名')</th>
                        <th class="log-th" scope="col"></th>
                        <th class="log-th" scope="col">@sortablelink('learned_at', '学習日')</th>
                        <th class="log-th" scope="col">@sortablelink('comprehension_id', '理解度')</th>
                        <th class="log-th">コメント</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr class="log-tr">
                            <td class="log-td">{{ $log->book->subject->name }}</td>
                            <td class="log-td"><a class="link"
                                    href="/books/{{ $log->book->id }}">{{ $log->book->name }}</a></td>
                            <td class="log-td">{{ $log->book->type->name }}{{ $log->number }}</td>
                            <td class="log-td">{{ $log->learned_at }}</td>
                            <td class="log-td">{{ $log->comprehension->name }}</td>
                            <td class="log-td">{{ $log->comment }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{ $logs->appends(request()->query())->links() }}
            </div>
        </div>
</x-app-layout>
