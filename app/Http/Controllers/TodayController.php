<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Log;
use App\Models\Subject;
use App\Models\Type;
use App\Models\Intarval;

class TodayController extends Controller
{
    public function show(Book $book){
        return view('today')->with(['books'=>$book->get()]);
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
    
    public function pass(){
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
