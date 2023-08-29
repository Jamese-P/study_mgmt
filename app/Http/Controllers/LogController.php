<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Subject;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Log $log, Subject $subject)
    {
        $log = $log->learned_logs()->sortable()->orderBy('learned_at', 'desc')->paginate(20);
        $values = [];
        foreach ($subject->get() as $sub) {
            array_push($values, $sub->id);
        }

        return view('logs.index')->with([
            'logs' => $log,
            'display_subjects' => $values,
            'subjects' => $subject->get(),
        ]);
    }

    public function refine(Log $log, Subject $subject, Request $request)
    {
        $input = $request['subject'];
        $values = [];
        foreach ($subject->get() as $sub) {
            if (in_array($sub->id, $input)) {
                array_push($values, $input[$sub->id]);
            }
        }

        $log = $log->whereNotNull('learned_at')
            ->whereHas('book', function ($query) use ($values) {
                $query->whereIn('subject_id', $values);
            })
            ->sortable()->orderBy('learned_at', 'desc')->paginate(20);

        return view('logs.index')->with([
            'logs' => $log,
            'display_subjects' => $values,
            'subjects' => $subject->get(),
        ]);
    }
}
