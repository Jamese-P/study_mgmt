<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LogRequest;
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
        $book_mgmts = $book_mgmt->get_under_progress()->get();
        $today = Carbon::today();

        //期限切れのある参考書の検索
        $book_exp = $book_mgmt->get_exp();

        //期限切れのログ検索
        $log_exp = Log::whereNotNull('scheduled_at')->get();

        //終了予定日の再計算
        foreach ($book_mgmts as $book) {
            $rest_times = ceil(($book->book->max - $book->finished) / $book->a_day) - 1;
            $book->end_date = Carbon::parse($book->next_learn_at)->addDays($rest_times * $book->intarval->days);
            $book->save();
        }

        $book_today = $book_mgmt->get_under_progress_byDate($today);
        $tomorrow = Carbon::tomorrow();
        $book_tomorrow = $book_mgmt->get_under_progress_byDate($tomorrow);

        return view('today.today')->with([
            'logs_exp' => $log_exp,
            'books_exp' => $book_exp,
            'books_today' => $book_today,
            'books_tomorrow' => $book_tomorrow,
        ]);
    }

    public function update_exp(Book $book)
    {
        $book_mgmt = $book->book_mgmt()->first();
        $schedule = Carbon::parse($book_mgmt->next_learn_at);

        for ($i = $book_mgmt->today_rest; $i > 0; $i--) {
            $log = $book->logs()->whereNull('learned_at')->whereNull('scheduled_at')->where('number', $book_mgmt->next)->first();
            if (! $log) {
                $log = new Log();
                $log->number = $book_mgmt->next;
            }
            $log->scheduled_at = $schedule;
            $log->save();

            $log_next = $book->logs()->whereNull('learned_at')->whereNull('scheduled_at')->orderBy('number', 'asc')->first();
            if ($log_next) {
                $book_mgmt->next = $log_next->number;
            } else {
                $book_mgmt->finish_flag = 1;
                break;
            }

            $book_mgmt->save();
        }

        $book_mgmt->today_rest = $book_mgmt->a_day;
        $book_mgmt->next_learn_at = $schedule->addDays($book_mgmt->intarval->days);
        $book_mgmt->save();

        return redirect(route('today'));
    }

    public function update_no_exp(Book $book)
    {
        $book_mgmt = $book->book_mgmt()->first();
        $schedule = Carbon::parse($book_mgmt->next_learn_at);
        $book_mgmt->today_rest = $book_mgmt->a_day;
        $book_mgmt->next_learn_at = $schedule->addDays($book_mgmt->intarval->days);
        $book_mgmt->save();

        return redirect(route('today'));
    }

    public function complete_indiv(Book $book, Comprehension $comprehension)
    {
        return view('today.complete_indiv')->with([
            'books' => $book->orderBy('updated_at', 'desc')->get(),
            'comprehensions' => $comprehension->get(),
        ]);
    }

    public function complete_indiv_log(LogRequest $request)
    {
        $input = $request['log'];

        $book_id = $input['book_id'];
        $book = Book::where('id', $book_id)->first();

        $unit = $input['number'];

        $log = $book->logs()->whereNull('learned_at')->where('number', $unit)->first();
        if (! $log) {
            $log = new Log();
        }

        $log->fill($input);
        $log->learned_at = new DateTimeImmutable();
        $log->scheduled_at = null;
        $log->save();

        return redirect(route('today'));
    }

    public function complete(Book $book, int $unit, Comprehension $comprehension)
    {
        return view('today.complete')->with([
            'book' => $book,
            'unit' => $unit,
            'comprehensions' => $comprehension->get(),
        ]);
    }

    public function complete_log(Request $request, Book $book, int $unit)
    {
        $input = $request['log'];
        $log = $book->logs()->whereNull('learned_at')->whereNull('scheduled_at')->where('number', $unit)->first();
        if (! $log) {
            $log = new Log();
            $log->book_id = $book->id;
            $log->number = $unit;
        }
        $log->fill($input);
        $log->learned_at = new DateTimeImmutable();
        $log->save();

        $book_mgmt = $book->book_mgmt()->first();
        $log_next = $book->logs()->whereNull('learned_at')->whereNull('scheduled_at')->orderBy('number', 'asc')->first();
        if ($log_next) {
            $book_mgmt->next = $log_next->number;
            $book_mgmt->today_rest--;
            if ($book_mgmt->today_rest === 0) {
                $book_mgmt->next_learn_at = Carbon::parse($book_mgmt->next_learn_at)->addDays($book_mgmt->intarval->days);
                $book_mgmt->today_rest = $book_mgmt->a_day;
            }
        } else {
            $book_mgmt->finish_flag = 1;
        }
        $book_mgmt->finished = $unit;
        $book_mgmt->save();

        return redirect(route('today'));
    }

    public function pass(Book $book, int $unit)
    {
        $log = $book->logs()->whereNull('learned_at')->where('number', $unit)->first();
        if ($log) {
            $log->delete();
        }

        $book_mgmt = $book->book_mgmt()->first();
        $log_next = $book->logs()->whereNull('learned_at')->whereNull('scheduled_at')->orderBy('number', 'asc')->first();
        if ($log_next) {
            $book_mgmt->next = $log_next->number;
        } else {
            $book_mgmt->finish_flag = 1;
        }
        $book_mgmt->finished = $unit;
        $book_mgmt->save();

        return redirect(route('today'));
    }

    public function comp_exp(Book $book, int $unit, Comprehension $comprehension)
    {
        return view('today.complete_exp')->with([
            'book' => $book,
            'unit' => $unit,
            'comprehensions' => $comprehension->get(),
        ]);
    }

    public function comp_exp_log(Request $request, Book $book, int $unit)
    {
        $input = $request['log'];
        $log = $book->logs()->whereNull('learned_at')->whereNotNull('scheduled_at')->where('number', $unit)->first();
        if (! $log) {
            $log = new Log();
            $log->book_id = $book->id;
            $log->number = $unit;
        }
        $log->fill($input);
        $log->learned_at = new DateTimeImmutable();
        $log->scheduled_at = null;
        $log->save();

        return redirect(route('today'));
    }

    public function pass_exp(Book $book, int $unit)
    {
        $log = $book->logs()->whereNull('learned_at')->whereNotNull('scheduled_at')->where('number', $unit)->first();
        if ($log) {
            $log->delete();
        }

        return redirect(route('today'));
    }
}
