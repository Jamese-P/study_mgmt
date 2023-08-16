<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function index()
    {
        $log = Log::whereHas('book', function ($query) {
            $query->where('user_id', Auth::id());
        })->whereNotNull('learned_at')->orderBy('learned_at', 'desc')->get();

        return view('logs.index')->with(['logs' => $log]);
    }
}
