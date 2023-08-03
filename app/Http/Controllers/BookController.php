<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\Intarval;
use App\Models\Log;
use App\Models\Subject;
use App\Models\Type;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Book $book)
    {
        return view('books.index')->with(['books' => $book->get()]);
    }

    public function show(Book $book)
    {
        $log = Log::where('book_id', $book->id)->get();

        return view('books.show')->with(['book' => $book, 'logs' => $log]);
    }

    public function create(Subject $subject, Type $type, Intarval $intarval)
    {
        return view('books.create')->with(['subjects' => $subject->get(),
            'types' => $type->get(),
            'intarvals' => $intarval->get()]);
    }

    public function store(BookRequest $request, Book $book)
    {
        $input = $request['book'];
        $book->fill($input);
        $book->user_id = '1';
        $book->finished = '0';
        $book->today_finished = '0';
        $book->save();

        return redirect('/books/'.$book->id);
    }

    public function edit(Book $book, Subject $subject, Type $type, Intarval $intarval)
    {
        return view('books.edit')->with(['book' => $book,
            'subjects' => $subject->get(),
            'types' => $type->get(),
            'intarvals' => $intarval->get()]);
    }

    public function update(Request $request, Book $book)
    {
        $input = $request['book'];
        $book->fill($input);
        $book->save();

        return redirect('/books/'.$book->id);
    }
}
