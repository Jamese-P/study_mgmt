<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function get(Request $request, Schedule $schedule)
    {
        $request->validate([
            'start_date' => 'required|integer',
            'end_date' => 'required|integer',
        ]);

        // カレンダー表示期間
        $start_date = date('Y-m-d', $request->input('start_date') / 1000);
        $end_date = date('Y-m-d', $request->input('end_date') / 1000);

        // 登録処理
        return $schedule->query()
            ->select(
                // FullCalendarの形式に合わせる
                'id',
                'start_date as start',
                'end_date as end',
                'name as title',
                'editable',
                'backgroundColor',
                'borderColor',
            )
            ->where('user_id', Auth::id())
            // FullCalendarの表示範囲のみ表示
            ->where('end_date', '>', $start_date)
            ->where('start_date', '<', $end_date)
            ->get();
    }

    public function create(Schedule $schedule, Request $request)
    {
        $input = $request['schedule'];

        $schedule->borderColor = $input['backgroundColor'];
        $schedule->fill($input);
        $schedule->end_date = Carbon::parse($input['end_date'])->addDays(1);
        $schedule->save();

        return redirect(route('calendar'));
    }

    public function update(Request $request)
    {
        $schedule = Schedule::find($request->input('id'));
        $input = $request['schedule'];
        $schedule->borderColor = $input['backgroundColor'];
        $schedule->fill($input);
        $schedule->end_date = Carbon::parse($input['end_date'])->addDays(1);
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
