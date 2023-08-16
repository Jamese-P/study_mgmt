<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Book_mgmtRequest;
use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\Book_mgmt;
use App\Models\Comprehension;
use App\Models\Intarval;
use App\Models\Log;
use App\Models\Subject;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class BookController extends Controller
{
    public function index(Book_mgmt $book_mgmt)
    {
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

    public function store(BookRequest $book_request, Book_mgmtRequest $book_mgmt_request, Book $book, Book_mgmt $book_mgmt)
    {
        $input = $book_request['book'];
        $book->fill($input);
        $book->user_id = Auth::id();
        $book->save();

        $input = $book_mgmt_request['book_mgmt'];
        $book_mgmt->fill($input);
        $book_mgmt->user_id = Auth::user()->id;
        $book_mgmt->finished = '0';
        $book_mgmt->book_id = $book->id;
        $book_mgmt->save();

        $book_mgmt->today_rest = $book_mgmt->a_day;

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

    public function update(BookRequest $book_request, Book_mgmtRequest $book_mgmt_request, Book $book)
    {
        $book_mgmt = $book->book_mgmt()->first();

        $input = $book_request['book'];
        $book->fill($input);
        $book->save();

        $input = $book_mgmt_request['book_mgmt'];
        $book_mgmt->fill($input);
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
    }

    public function relearn(Book $book, Intarval $intarval, Comprehension $comprehension)
    {
        return view('books.relearn')->with([
            'book' => $book,
            'intarvals' => $intarval->get(),
            'comprehensions' => $comprehension->get(),
        ]);
    }

    public function make_log_relearn(Book $book, Request $request, Book_mgmtRequest $book_mgmt_request)
    {
        $book_mgmt = $book->book_mgmt()->first();

        $input = $book_mgmt_request['book_mgmt'];
        $book_mgmt->fill($input);
        $book_mgmt->finished = '0';
        $book_mgmt->finish_flag = '0';
        $book_mgmt->save();

        $comprehension = $request->comprehension_id;

        for ($i = 1; $i <= $book->max; $i++) {
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
            $book_mgmt->finish_flag = 1;
        }
        $book_mgmt->today_rest = $book_mgmt->a_day;
        $book_mgmt->save();

        return redirect('/books');
    }
}
