<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Log $log,Subject $subject)
    {
        $log = $log->learned_logs()->sortable()->orderBy('learned_at', 'desc')->paginate(20);

        return view('logs.index')->with([
            'logs' => $log,
            'subjects' => $subject->get(),
            ]);
    }
    
    public function refine(Log $log,Subject $subject,Request $request)
    {
        $log = $log->whereNotNull('learned_at')->sortable()->orderBy('learned_at', 'desc')->paginate(20);

        return view('logs.index')->with([
            'logs' => $log,
            'subjects' => $subject->get(),
            ]);
    }
}
