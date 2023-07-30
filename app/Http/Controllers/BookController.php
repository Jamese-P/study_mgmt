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
    
    public function create(Subject $subject,Type $type,Intarval $intarval){
        return view('books.create')->with(['subjects'=>$subject->get(),
                                            'types'=>$type->get(),
                                            'intarvals'=>$intarval->get()]);
    }
    
    public function store(Request $request,Book $book){
        $input=$request['book'];
        $book->fill($input);
        $book->user_id='1';
        $book->finished='0';
        $book->today_finished='0';
        $book->save();
        return redirect('/books'.$book->id);
    }
    
    public function edit(){
        
    }
    
}
