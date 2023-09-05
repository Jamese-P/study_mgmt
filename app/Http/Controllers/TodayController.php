<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LogRequest;
use App\Models\Book;
use App\Models\Book_mgmt;
use App\Models\Comprehension;
use App\Models\Log;
use App\Models\Subject;
use Carbon\Carbon;
use DateTimeImmutable;
use Illuminate\Support\Facades\Auth;

class TodayController extends Controller
{
    public function show(Log $log, Book_mgmt $book_mgmt, Comprehension $comprehension)
    {
        $book_mgmts = Book_mgmt::where('user_id', Auth::id())->get();

        foreach ($book_mgmts as $book) {
            $logs = $book->book()->first()->logs()->count();
            $logs_learn = $book->book()->first()->logs()->whereNotNull('learned_at')->count();
            $book->percent = round($logs_learn / $logs * 100, 1);
            //終了予定日の再計算
            if ($book->next != -1) {
                $rest_times = ceil(($book->book->max - $book->next + 1) / $book->a_day) - 1;
                $book->end_date = Carbon::parse($book->next_learn_at)->addDays($rest_times * $book->intarval->days);
                $book->save();

                $schedule = $book->schedule()->first();
                $schedule->start_date = $book->end_date;
                $schedule->end_date = $book->end_date;
                $schedule->save();
            }
            $book->save();
        }

        $book_mgmts = $book_mgmt->get_under_progress()->get();
        $today = Carbon::today();

        //期限切れのある参考書の検索
        $book_exp = $book_mgmt->get_exp();

        //期限切れのログ検索
        $log_exp = $log->scheduled_logs()->orderBy('scheduled_at', 'asc')->get();

        $book_today = $book_mgmt->get_under_progress_byDate($today);
        $tomorrow = Carbon::tomorrow();
        $book_tomorrow = $book_mgmt->get_under_progress_byDate($tomorrow);

        return view('today.today')->with([
            'logs_exp' => $log_exp,
            'books_exp' => $book_exp,
            'books_today' => $book_today,
            'books_tomorrow' => $book_tomorrow,
            'comprehensions' => $comprehension->get(),
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
                $log->book_id = $book->id;
                $log->number = $book_mgmt->next;
            }
            $log->scheduled_at = $schedule;
            $log->save();

            $log_next = $book->logs()->whereNull('learned_at')->whereNull('scheduled_at')->orderBy('number', 'asc')->first();
            if ($log_next) {
                $book_mgmt->next = $log_next->number;
            } else {
                $book_mgmt->next = -1;
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

    public function complete_indiv(Book $book, Comprehension $comprehension, Subject $subject)
    {
        return view('today.complete_indiv')->with([
            'books' => $book->orderBy('updated_at', 'desc')->get(),
            'comprehensions' => $comprehension->get(),
            'subjects' => $subject->get(),
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
            if ($unit >= $book->start && $unit <= $book->max) {
                $log = new Log();
            } else {
                return redirect(route('today'));
            }
        }

        $log->fill($input);
        $log->learned_at = new DateTimeImmutable();
        $log->scheduled_at = null;
        $log->save();

        return redirect(route('today'));
    }

    public function complete(LogRequest $request)
    {
        $input = $request['log'];

        $book = Book::find($input['book_id']);
        $book_mgmt = Book_mgmt::where('book_id', $input['book_id'])->first();

        $log = $book->logs()->whereNull('learned_at')->whereNull('scheduled_at')->where('number', $input['number'])->first();
        if (! $log) {
            $log = new Log();
        }
        $log->fill($input);
        $log->learned_at = new DateTimeImmutable();
        $log->save();

        $log_next = $book->logs()->whereNull('learned_at')->whereNull('scheduled_at')->orderBy('number', 'asc')->first();
        if ($log_next) {
            $book_mgmt->next = $log_next->number;
            $book_mgmt->today_rest--;
            if ($book_mgmt->today_rest === 0) {
                $book_mgmt->next_learn_at = Carbon::parse($book_mgmt->next_learn_at)->addDays($book_mgmt->intarval->days);
                $book_mgmt->today_rest = $book_mgmt->a_day;
            }
        } else {
            $book_mgmt->next = -1;
        }
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
            $book_mgmt->next = -1;
        }
        $book_mgmt->save();

        return redirect(route('today'));
    }

    public function comp_exp(LogRequest $request)
    {
        $input = $request['log'];

        $book = Book::find($input['book_id']);
        $book_mgmt = Book_mgmt::where('book_id', $input['book_id'])->first();

        $log = $book->logs()->whereNull('learned_at')->whereNotNull('scheduled_at')->where('number', $input['number'])->first();
        if (! $log) {
            $log = new Log();
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
