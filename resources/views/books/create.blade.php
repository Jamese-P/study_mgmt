<x-app-layout>
        <div class="form1">
            <form action="/books" method="POST" class="form-book">
                @csrf
                <input type="hidden" name="book[user_id]" value="{{ Auth::id() }}">
                <input type="hidden" name="book_mgmt[user_id]" value="{{ Auth::id() }}">
                <div class="form-element">
                    <label for="name" class="form-label">参考書名</label>
                    <input type="text" name="book[name]" id="name" class="form-input" placeholder="参考書名"
                        value="{{ old('book.name') }}" />
                    <p class="name__error" style="color:red">{{ $errors->first('book.name') }}</p>
                </div>
                <div class="form-grid">
                    <div class="form-element">
                        <label for="subject" class="form-label">教科</label>
                        <select id="subject" class="form-select" name="book[subject_id]">
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" @if ($subject->id === (int) old('book.subject_id')) selected @endif>
                                    {{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-element">
                        <label for="type" class="form-label">単元またはページ</label>
                        <select id="type" class="form-select" name="book[type_id]">
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}" @if ($type->id === (int) old('book.type_id')) selected @endif>
                                    {{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-element">
                        <label for="start" class="form-label">初回学習単元またはページ</label>
                        <input id="start" class="form-number" type="number" name="book[start]" placeholder="開始ページ"
                            value="{{ old('book.start', 1) }}">
                        <p class="next__error" style="color:red">{{ $errors->first('book.start') }}</p>
                        <input type="hidden" name="book_mgmt[next]" value="{{ old('book.start', 1) }}">
                    </div>
                    <div class="form-element">
                        <label for="finish" class="form-label">終了単元またはページ</label>
                        <input type="number" id="finish" class="form-number" name="book[max]" placeholder="終了ページ"
                            value="{{ old('book.max') }}">
                        <p class="max__error" style="color:red">{{ $errors->first('book.max') }}</p>
                    </div>
                    <div class="form-element">
                        <label for="intarval" class="form-label">学習間隔</label>
                        <select id="intarval" class="form-select" name="book_mgmt[intarval_id]">
                            @foreach ($intarvals as $intarval)
                                <option value="{{ $intarval->id }}" @if ($intarval->id === (int) old('book_mgmt.intarval_id')) selected @endif>
                                    {{ $intarval->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-element">
                        <label for="a_day" class="form-label">1日の学習単元またはページ</label>
                        <input type="number" id="a_day" class="form-number" name="book_mgmt[a_day]"
                            placeholder="1日の学習ページ" value="{{ old('book_mgmt.a_day') }}">
                        <p class="a_day__error" style="color:red">{{ $errors->first('book_mgmt.a_day') }}</p>
                    </div>
                </div>
                <div class="form-element">
                    <label for="next_learn_at" class="form-label">初回学習日</label>
                    <input type="date" id="next_learn_at" class="form-date" name="book_mgmt[next_learn_at]"
                        value="{{ old('book_mgmt.next_learn_at', \Carbon\Carbon::today()->format('Y-m-d')) }}">
                    <p class="next_learn_at__error" style="color:red">{{ $errors->first('book_mgmt.next_learn_at') }}
                    </p>
                </div>
                    <div class="form-element text-right">
                        <p id="end_date"></p>
                    </div>
                <input type="submit" class="form-submit" value="保存" />
            </form>
        </div>
        <script>
            function inputChange(){
                let start=document.getElementById('start').value;
                let finish=document.getElementById('finish').value;
                let intarval=document.getElementById('intarval').value;
                let a_day=document.getElementById('a_day').value;
                let next_learn_at=document.getElementById('next_learn_at').value;
                let end_date=document.getElementById('end_date');
                const intarvals=@json($intarvals);
                
                if(start != null && start != ""){
                    if(finish != null && finish != ""){
                        if(intarval != null && intarval != ""){
                            
                            let intarval_days=intarvals[intarval-1]["days"];
                            
                            if(a_day != null && a_day != ""){
                                let rest_times = Math.ceil((finish - start + 1) / a_day) - 1;
                                let date=new Date(next_learn_at);
                                date.setDate(date.getDate()+rest_times*intarval_days);
                                var year_str = date.getFullYear();
                                //月だけ+1すること
                                var month_str = 1 + date.getMonth();
                                var day_str = date.getDate();
                            
                                let format_str = 'YYYY-MM-DD';
                                format_str = format_str.replace(/YYYY/g, year_str);
                                format_str = format_str.replace(/MM/g, ('00' + month_str).slice(-2));
                                format_str = format_str.replace(/DD/g, ('00' + day_str).slice(-2));
                                
                                end_date.innerHTML="終了予定日:"+format_str;
                            }
                        }
                    }
                }
            }
            
            start.oninput=inputChange;
            finish.oninput=inputChange;
            intarval.oninput=inputChange;
            a_day.oninput=inputChange;
            next_learn_at.oninput=inputChange;
            
        </script>
</x-app-layout>
