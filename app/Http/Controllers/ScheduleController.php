<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function store(Schedule $schedule, Request $request)
    {
        $request->validate([
            'start_date' => 'required|integer',
            'end_date' => 'required|integer',
            'name' => 'required|max:32',
        ]);

        // 日付に変換。JavaScriptのタイムスタンプはミリ秒なので秒に変換
        $schedule->start_date = date('Y-m-d', $request->input('start_date') / 1000);
        $schedule->end_date = date('Y-m-d', $request->input('end_date') / 1000);
        $schedule->name = $request->input('name');
        $schedule->save();
    }

    public function get(Request $request)
    {
        $request->validate([
            'start_date' => 'required|integer',
            'end_date' => 'required|integer',
        ]);

        // カレンダー表示期間
        $start_date = date('Y-m-d', $request->input('start_date') / 1000);
        $end_date = date('Y-m-d', $request->input('end_date') / 1000);

        // 登録処理
        return Schedule::query()
            ->select(
                // FullCalendarの形式に合わせる
                'id',
                'start_date as start',
                'end_date as end',
                'name as title'
            )
            // FullCalendarの表示範囲のみ表示
            ->where('end_date', '>', $start_date)
            ->where('start_date', '<', $end_date)
            ->get();
    }

    public function create(Schedule $schedule, Request $request)
    {
        $input = $request['schedule'];

        $schedule->fill($input)->save();

        return redirect(route('calendar'));
    }

    public function update(Request $request)
    {
        $schedule = Schedule::find($request->input('id'));
        $input = $request['schedule'];
        $schedule->fill($input)->save();

        return redirect(route('calendar'));
    }

    public function drop(Request $request)
    {
        $schedule = Schedule::find($request->input('id'));

        $start_date = date('Y-m-d', $request->input('start_date') / 1000);
        $end_date = date('Y-m-d', $request->input('end_date') / 1000);

        $schedule->start_date = $start_date;
        $schedule->end_date = $end_date;
        $schedule->save();

        return redirect(route('calendar'));
    }

    public function delete(Request $request)
    {
        $schedule = Schedule::find($request->input('id'));
        $schedule->delete();

        return redirect(route('calendar'));
    }
}