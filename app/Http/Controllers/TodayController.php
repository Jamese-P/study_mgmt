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
use Illuminate\Support\Facades\Auth;

class TodayController extends Controller
{
    public function show(Book_mgmt $book_mgmt)
    {
        //ページを開いた時
        $book_mgmts = $book_mgmt->get_under_progress();
        $today = Carbon::today();

        $this->update_next_learn();

        //終了予定日の再計算
        foreach ($book_mgmts as $book) {
            $rest_times = ceil(($book->book->max - $book->finished) / $book->a_day) - 1;
            $book->end_date = Carbon::parse($book->next_learn_at)->addDays($rest_times * $book->intarval->days);
            $book->save();
        }

        //$book_today = Book_mgmt::whereDate('next_learn_at', $today)->where('user_id', Auth::id())->get();
        $book_today = $book_mgmt->get_under_progress_byDate($today);
        $tomorrow = Carbon::tomorrow();
        $book_tomorrow = $book_mgmt->get_under_progress_byDate($tomorrow);

        return view('today')->with(['books_today' => $book_today, 'books_tomorrow' => $book_tomorrow]);
    }

    private function update_next_learn()
    {
        //すべてのものを更新
        $book_mgmt = new Book_mgmt();
        $book_mgmts = $book_mgmt->get_under_progress();
        $today = Carbon::today();
        foreach ($book_mgmts as $book) {
            $schedul = Carbon::parse($book->next_learn_at);
            if ($schedul->lt($today)) {
                $book->finished = $book->today_finished;
                $book->next_learn_at = $schedul->addDays($book->intarval->days);

                if ($book->book->max === $book->today_finished) {
                    $book->finish_flag = 1;
                }
                $book->save();
            }
        }
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

        $book_mgmt = $book->book_mgmt()->first();
        $book_mgmt->today_finished = $book_mgmt->today_finished + 1;

        $log->save();
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

        $book_mgmt = $book->book_mgmt()->first();
        $book_mgmt->today_finished = $book_mgmt->today_finished + 1;

        $log->save();
        $book_mgmt->save();

        return redirect('/today');
    }
}
