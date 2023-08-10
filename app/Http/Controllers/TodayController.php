<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Book_mgmt;
use App\Models\Comprehension;
use App\Models\Log;
use Carbon\Carbon;
use DateTimeImmutable;
use Illuminate\Http\Request;

class TodayController extends Controller
{
    public function show()
    {
        //ページを開いた時
        //昨日が予定日のものの更新
        $yesterday = Carbon::yesterday();
        $book_yesterday = Book_mgmt::whereDate('next_learn_at', $yesterday)->get();
        foreach ($book_yesterday as $book) {
            $book->finished = $book->today_finished;
            $book->next_learn_at = Carbon::createFromFormat('Y-m-d', $book->next_learn_at)->addDays($book->intarval->days);
            $book->save();
        }

        $book_mgmts = Book_mgmt::get();
        //終了予定日の再計算
        foreach ($book_mgmts as $book) {
            $rest_times = ceil(($book->book->max - $book->finished) / $book->a_day) - 1;
            $book->end_date = Carbon::parse($book->next_learn_at)->addDays($rest_times * $book->intarval->days);
            $book->save();
        }

        $today = Carbon::today();
        $book_today = Book_mgmt::whereDate('next_learn_at', $today)->get();
        $tomorrow = Carbon::tomorrow();
        $book_tomorrow = Book_mgmt::whereDate('next_learn_at', $tomorrow)->get();

        return view('today')->with(['books_today' => $book_today, 'books_tomorrow' => $book_tomorrow]);
    }

    public function complete2(Book $book)
    {
        $log = new Log();
        $log->book_id = $book->id;
        $log->number = $book->today_finished + 1;
        $log->comprehension_id = '2';
        $log->learned_at = new DateTimeImmutable();

        $book->today_finished = $book->today_finished + 1;

        $log->save();
        $book->save();

        return redirect('/today');
    }

    public function complete(Book $book, int $unit)
    {
        $comprehension = Comprehension::all();

        return view('complete')->with([
            'book' => $book,
            'unit' => $unit,
            'comprehensions' => $comprehension]);
    }

    public function make_log(Request $request, Book $book, int $unit)
    {
        $input = $request['log'];
        $log = new Log();
        $log->fill($input);
        $log->book_id = $book->id;
        $log->number = $unit;
        $log->learned_at = new DateTimeImmutable();

        $book_mgmt = Book_mgmt::where('book_id', $book->id)->first();
        $book_mgmt->today_finished = $book_mgmt->today_finished + 1;

        $log->save();
        $book->save();
        $book_mgmt->save();

        return redirect('/today');
    }

    public function pass(Book $book)
    {
        $log = new Log();
        $log->book_id = $book->id;
        $log->number = $book->today_finished + 1;
        $log->comprehension_id = '1';
        $log->passed_at = new DateTimeImmutable();

        $book->today_finished = $book->today_finished + 1;

        $log->save();
        $book->save();

        return redirect('/today');
    }
}
