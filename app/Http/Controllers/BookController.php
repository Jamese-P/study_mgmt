<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Log;
use App\Models\Subject;
use App\Models\Type;
use App\Models\Intarval;

class BookController extends Controller
{
    public function index(Book $book){
        return view('books.index')->with(['books'=>$book->get()]);
    }
    
}
