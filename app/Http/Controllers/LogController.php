<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Book_mgmt;
use App\Models\Comprehension;
use App\Models\Log;
use Carbon\Carbon;
use DateTimeImmutable;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(){
        $log=Log::whereHas('book',function($query){
            $query->where('user_id',Auth::id());
        })->whereNotNull('learned_at')->orWhereNotNull('passed_at')->orderBy('learned_at', 'desc')->get();
        
        return view('logs.index')->with(['logs'=>$log]);
    }
}
