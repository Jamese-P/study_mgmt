<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\Book_mgmt;
use App\Models\Comprehension;
use App\Models\Intarval;
use App\Models\Log;
use App\Models\Subject;
use App\Models\Type;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

final class BookController extends Controller
{
    public function index(Book_mgmt $book_mgmt)
    {
        $book_mgmts = Book_mgmt::where('user_id',Auth::id())->get();

        foreach ($book_mgmts as $book) {
            $logs = $book->book()->first()->logs()->count();
            $logs_learn = $book->book()->first()->logs()->whereNotNull('learned_at')->count();
            $book->percent = round($logs_learn / $logs * 100, 1);
            //終了予定日の再計算
            if ($book->next != -1) {
                $rest_times = ceil(($book->book->max - $book->next + 1) / $book->a_day) - 1;
                $book->end_date = Carbon::parse($book->next_learn_at)->addDays($rest_times * $book->intarval->days);
                $book->save();
                
                $schedule=$book->schedule()->first();
                $schedule->start_date=$book->end_date;
                $schedule->end_date=$book->end_date;
                $schedule->save();
            }
            $book->save();
        }
        
        $book_progress = $book_mgmt->get_under_progress()->get();
        $book_finish = $book_mgmt->get_finished();

        return view('books.index')->with([
            'book_progress' => $book_progress,
            'book_finish' => $book_finish,
        ]);
    }

    public function show(Book $book)
    {
        $log = $book->logs()->whereNotNull('learned_at')->orderBy('learned_at', 'desc')->get();
        $book_mgmt = $book->book_mgmt()->first();

        return view('books.show')->with(['book_mgmt' => $book_mgmt, 'logs' => $log]);
    }

    public function create(Subject $subject, Type $type, Intarval $intarval)
    {
        return view('books.create')->with([
            'subjects' => $subject->get(),
            'types' => $type->get(),
            'intarvals' => $intarval->get()]);
    }

    public function store(BookRequest $book_request, Book $book, Book_mgmt $book_mgmt)
    {
        $input = $book_request['book'];
        $book->fill($input);
        $book->user_id = Auth::id();
        $book->save();

        $input = $book_request['book_mgmt'];
        
        $schedule=new Schedule();
        $schedule->user_id = Auth::id();
        $schedule->name="終了予定日:".$book->name;
        $schedule->editable=0;
        $schedule->backgroundColor="purple";
        $schedule->borderColor="purple";
        $schedule->start_date=$input['next_learn_at'];
        $schedule->end_date=$input['next_learn_at'];
        $schedule->save();
        
        $book_mgmt->fill($input);
        $book_mgmt->user_id = Auth::user()->id;
        $book_mgmt->book_id = $book->id;
        $book_mgmt->next = $book->start;
        $book_mgmt->today_rest = $input['a_day'];
        $book_mgmt->schedule_id=$schedule->id;
        $book_mgmt->save();

        $this->logs_to_learn($book_mgmt->next, $book->max, $book);

                    
                    

        return redirect('/books/'.$book->id);
    }

    private function logs_to_learn(int $start, int $finish, Book $book)
    {
        for ($i = $start; $i <= $finish; $i++) {
            $log = new Log();
            $log->book_id = $book->id;
            $log->number = $i;
            $log->save();
        }
    }

    public function edit(Book $book, Subject $subject, Type $type, Intarval $intarval)
    {
        $book_mgmt = $book->book_mgmt()->first();

        return view('books.edit')->with([
            'book_mgmt' => $book_mgmt,
            'subjects' => $subject->get(),
            'types' => $type->get(),
            'intarvals' => $intarval->get()]);
    }

    public function update(BookRequest $book_request, Book $book)
    {
        $book_mgmt = $book->book_mgmt()->first();

        $input = $book_request['book'];
        $book->fill($input);
        $book->save();

        $finish = $book_mgmt->a_day - $book_mgmt->today_rest;

        $input = $book_request['book_mgmt'];
        $book_mgmt->fill($input);
        $book_mgmt->save();
        if ($finish >= $input['a_day']) {
            $book_mgmt->today_rest = $input['a_day'];
            $book_mgmt->next_learn_at = Carbon::parse($book_mgmt->next_learn_at)->addDays($book_mgmt->intarval->days);
        } else {
            $book_mgmt->today_rest = $input['a_day'] - $finish;
        }
        $book_mgmt->save();

        $this->update_logs($book_mgmt->next, $book->max, $book);

        return redirect('/books/'.$book->id);
    }

    public function update_logs(int $start, int $finish, Book $book)
    {
        for ($i = 1; $i < $start; $i++) {
            $log = $book->logs()->whereNull('learned_at')->where('number', $i)->first();
            if ($log) {
                $log->delete();
            }
        }
        for ($i = $start; $i <= $finish; $i++) {
            $log = $book->logs()->whereNull('learned_at')->where('number', $i)->first();
            if (! $log) {
                $log = new Log();
                $log->book_id = $book->id;
                $log->number = $i;
                $log->save();
            }
        }

        while (1) {
            if (! $log = $book->logs()->whereNull('learned_at')->where('number', '>', $finish)->first()) {
                break;
            }
            $log->delete();
        }
    }

    public function relearn(Book $book, Intarval $intarval, Comprehension $comprehension)
    {
        $book_mgmt = $book->book_mgmt()->first();

        return view('books.relearn')->with([
            'book_mgmt' => $book_mgmt,
            'book' => $book,
            'intarvals' => $intarval->get(),
            'comprehensions' => $comprehension->get(),
        ]);
    }

    public function make_log_relearn(Book $book, Request $request, BookRequest $book_request)
    {
        $book_mgmt = $book->book_mgmt()->first();

        $input = $book_request['book_mgmt'];
        $book_mgmt->fill($input);
        $book_mgmt->save();

        if ($book->max <= $input['finish']) {
            $finish = $book->max;
        } else {
            $finish = $input['finish'];
        }

        $comprehension = $request->comprehension_id;

        for ($i = $book_mgmt->next; $i <= $finish; $i++) {
            $log = $book->logs()->where('number', $i)->orderBy('learned_at', 'desc')->first();
            if ($log && $log->comprehension_id >= $comprehension) {
                $log_new = new Log();
                $log_new->number = $log->number;
                $log_new->book_id = $book->id;
                $log_new->save();
            }
        }

        $log_next = $book->logs()->whereNull('learned_at')->orderBy('number', 'asc')->first();
        if ($log_next) {
            $book_mgmt->next = $log_next->number;
        } else {
            $book_mgmt->next = -1;
        }
        $book_mgmt->today_rest = $book_mgmt->a_day;
        $book_mgmt->save();

        return redirect('/books');
    }
}
