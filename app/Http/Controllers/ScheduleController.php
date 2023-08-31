<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function store(Schedule $schedule,Request $request){
        
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

        return;
    }
    
    public function get(Request $request)
    {
        $request->validate([
            'start_date' => 'required|integer',
            'end_date' => 'required|integer'
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
    
    public function create(Request $request){
        $schedule=new Schedule();
    }
    
    public function update(Request $request){
        $schedule=Schedule::find($request->input('id'));
        $input=$request['schedule'];
        $schedule->fill($input)->save();
        
        return redirect(route("calendar"));
    }
    
    public function delete(Request $request){
         $schedule=Schedule::find($request->input('id'));
         $schedule->delete();
         
         return redirect(route("calendar"));
    }
}
