<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Log;
use App\Models\Subject;
use App\Models\Type;
use App\Models\Intarval;
use Carbon\Carbon;

class TodayController extends Controller
{
    public function show(){
        $today=Carbon::today();
        $book_today=Book::whereDate('next_learn_at',$today)->get();
        $tomorrow=Carbon::tomorrow();
        $book_tomorrow=Book::whereDate('next_learn_at',$tomorrow)->get();
        return view('today')->with(['books_today'=>$book_today,'books_tomorrow'=>$book_tomorrow]);
    }
    
    public function complete(Book $book){
        $log=new Log();
        $log->book_id=$book->id;
        $log->number=$book->today_finished + 1;
        $log->comprehension_id='1';
        $log->learned_at=now();
        
        $book->today_finished=$book->today_finished + 1;
        
        $log->save();
        $book->save();
        
        return redirect('/today');
    }
    
    public function pass(Book $book){
        $log=new Log();
        $log->book_id=$book->id;
        $log->number=$book->today_finished + 1;
        $log->comprehension_id='1';
        $log->passed_at=now();
        
        $book->today_finished=$book->today_finished + 1;
        
        $log->save();
        $book->save();
        
        return redirect('/today');
    }
}
