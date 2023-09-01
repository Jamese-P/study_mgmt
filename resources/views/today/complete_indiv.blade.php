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
                    <label for="subject" class="form-label">教科</label>
                    <select id="subject" name="" class="form-select">
                        <option value="">教科を選択</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-element">
                    <div class="name">
                        <label for="book" class="form-label">参考書名</label>
                        <select id="book" name="log[book_id]" class="form-select">
                            <option value="">選択してください</option>
                        </select>
                        <p class="book_id__error" style="color:red">{{ $errors->first('log.book_id') }}</p>
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
                                <option value="{{ $comprehension->id }}" @if($comprehension->id === (int)old('log.comprehension_id')) selected @endif>{{ $comprehension->name }}</option>
                            @endforeach
                        </select>
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
        
        <script>
            const book_data=@json($books);
            const subjectInput = document.getElementById("subject");
            var bookSelect = document.getElementById("book");
            
            subjectInput.addEventListener('change',function(){
                bookSelect.textContent=null;
                const option = document.createElement('option');
                option.value = "";
                option.textContent = "選択してください";
                bookSelect.appendChild(option);
                
                book_data.forEach(book=>{
                    if(subjectInput.value == book.subject_id){
                        const option = document.createElement('option');
                        option.value = book.id;
                        option.textContent = book.name;
                        bookSelect.appendChild(option);
                    }
                });
            });
            
        </script>
    </body>

    </html>
</x-app-layout>
