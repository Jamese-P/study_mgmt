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
    public function show(Book_mgmt $book_mgmt)
    {
        //ページを開いた時
        $book_mgmts = $book_mgmt->get_under_progress();
        $today = Carbon::today();

        $today = Carbon::today();
        foreach ($book_mgmts as $book) {
            $schedul = Carbon::parse($book->next_learn_at);
            if ($schedul->lt($today)) {
                $book->today_rest = $book->book->max;
                $book->next_learn_at = $schedul->addDays($book->intarval->days);
                $book->save();
            }
        }

        //終了予定日の再計算
        foreach ($book_mgmts as $book) {
            $rest_times = ceil(($book->book->max - $book->finished) / $book->a_day) - 1;
            $book->end_date = Carbon::parse($book->next_learn_at)->addDays($rest_times * $book->intarval->days);
            $book->save();
        }

        $book_today = $book_mgmt->get_under_progress_byDate($today);
        $tomorrow = Carbon::tomorrow();
        $book_tomorrow = $book_mgmt->get_under_progress_byDate($tomorrow);

        return view('today')->with(['books_today' => $book_today, 'books_tomorrow' => $book_tomorrow]);
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
        $log = $book->logs()->whereNull('learned_at')->WhereNull('passed_at')->where('number', $unit)->first();
        if (! $log) {
            $log = new Log();
            $log->book_id = $book->id;
            $log->number = $unit;
        }
        $log->fill($input);
        $log->learned_at = new DateTimeImmutable();
        $log->save();

        $book_mgmt = $book->book_mgmt()->first();
        $log_next = $book->logs()->whereNull('learned_at')->WhereNull('passed_at')->orderBy('number', 'asc')->first();
        if ($log_next) {
            $book_mgmt->next = $log_next->number;
            $book_mgmt->today_rest--;
        } else {
            $book_mgmt->finish_flag = 1;
        }
        $book_mgmt->finished = $unit;
        $book_mgmt->save();

        return redirect('/today');
    }

    public function pass(Book $book, int $unit)
    {
        $log = $book->logs()->whereNull('learned_at')->WhereNull('passed_at')->where('number', $unit)->first();
        if (! $log) {
            $log = new Log();
            $log->book_id = $book->id;
            $log->number = $unit;
        }
        $log->comprehension_id = '1';
        $log->passed_at = new DateTimeImmutable();
        $log->save();

        $book_mgmt = $book->book_mgmt()->first();
        $log_next = $book->logs()->whereNull('learned_at')->WhereNull('passed_at')->orderBy('number', 'asc')->first();
        if ($log_next) {
            $book_mgmt->next = $log_next->number;
        } else {
            $book_mgmt->finish_flag = 1;
        }
        $book_mgmt->finished = $unit;
        $book_mgmt->save();

        return redirect('/today');
    }
}
