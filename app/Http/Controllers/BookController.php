<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\BookRequest;
use App\Models\Book_mgmt;
use App\Models\Book;
use App\Models\Intarval;
use App\Models\Log;
use App\Models\Subject;
use App\Models\Type;

final class BookController extends Controller
{
    public function index(Book_mgmt $book_mgmt)
    {
        //ページを開いた時
        return view('books.index')->with(['book_mgmts' => $book_mgmt->get()]);
    }

    public function show(Book $book)
    {
        $log = Log::where('book_id', $book->id)->get();
        $book_mgmt=Book_mgmt::where('book_id',$book->id)->first();

        return view('books.show')->with(['book_mgmt' => $book_mgmt, 'logs' => $log]);
    }

    public function create(Subject $subject, Type $type, Intarval $intarval)
    {
        return view('books.create')->with([
            'subjects' => $subject->get(),
            'types' => $type->get(),
            'intarvals' => $intarval->get()]);
    }

    public function store(Request $request, Book $book, Book_mgmt $book_mgmt)
    {
        $input = $request['book'];
        $book->fill($input);
        $input = $request['book_mgmt'];
        $book_mgmt->fill($input);
        $book_mgmt->user_id = '1';
        $book_mgmt->finished = '0';
        $book_mgmt->today_finished = '0';
        $book->save();
        $book_mgmt->book_id=$book->id;
        $book_mgmt->save();

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
