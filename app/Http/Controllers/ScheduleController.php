<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;


class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $schedule = new Schedule();
            $schedule->start_time = $request->start_time;
            $schedule->end_time = $request->end_time;
            $schedule->start_date = $request->start_date;
            $schedule->end_date = $request->end_date;
            if ($schedule->save()>=1) {
                return response()->json(['status'=>'OK','data'=>$schedule],201);
            }
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($paginate = null)
    {
        try {
            if ($paginate === 'paginate') {
                $schedule = Schedule::select('schedules.id','schedules.start_time','schedules.end_time','schedules.start_date','schedules.end_date','schedules.status')
                ->orderBy('id','desc')->paginate(5)->onEachSide(1);
                return $schedule;
            }
            else if (!$paginate) {
                $schedule = Schedule::select('schedules.id','schedules.start_time','schedules.end_time','schedules.start_date','schedules.end_date','schedules.status')
                ->orderBy('id','desc')
                ->get();
                return $schedule;
            }
            else {
                return response()->json(["message" => "Argument '". $paginate . "' does not exist"],404);
            }
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $schedule = Schedule::findOrFail($request->id);
            $schedule->start_time = $request->start_time;
            $schedule->end_time = $request->end_time;
            $schedule->status = $request->status;
            if ($schedule->save()>=1) {
                return response()->json(['status'=>'OK','data'=>$schedule],202);
            }
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
