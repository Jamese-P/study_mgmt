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
            <form action="{{ route('today.comp_log', ['book' => $book->id, 'unit' => $unit]) }}" method="POST" class="form-log">
                @csrf
                @method('PUT')
                <div class="form-element">
                    <div class="name">
                        <h1 class="txt-h1">{{ $book->name }} {{ $book->type->name }}{{ $unit }}</h1>
                    </div>
                </div>
                <input type="hidden" name="log[number]" value="{{ $unit }}">
                <div class="form-element">
                    
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

        <div class="back">
            [<a href="/">back</a>]
        </div>
    </body>

    </html>
</x-app-layout>
