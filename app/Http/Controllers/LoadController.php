<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use Illuminate\Http\Request;
use App\Models\Load;
use Illuminate\Support\Facades\DB;

class LoadController extends Controller
{
    public function index()
    {
        
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
        try{
            $load = new Load();
            $load->user_id = $request->user_id;
            $load->cycle_id = $request->cycle_id;
            $load->subject_id = $request->subject_id;
            $load->schedule_id = $request->schedule_id;
            if($load->save()>=1){
                return response()->json(['status'=>'ok','data'=>$load],201);
            }
            $load->save();
        }catch(\Exception $e){
            return response()->json(["message" => $e->getMessage()],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        try {
            $loads = Load::join('users', 'loads.user_id', '=', 'users.id')
            ->join('cycles', 'loads.cycle_id', '=', 'cycles.id')
            ->join('subjects', 'loads.subject_id', '=', 'subjects.id')
            ->join('schedules', 'loads.schedule_id', '=', 'schedules.id')
            ->select(
                'loads.id',
                'loads.status',
                'cycles.id as cycleId',
                'cycles.cycle',
                'users.id as userId',
                DB::raw("CONCAT(users.name,' ',users.last_name) AS teacher"),
                'subjects.id as subjectId',
                'subjects.subject',
                'schedules.id as scheduleId',
                'schedules.start_time',
                'schedules.end_time',
            )
            ->orderBy('id', 'desc')
            ->paginate(5)->onEachSide(1);
            return $loads;
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }

    public function getTeacherLoads(Request $request) {
        try {
            $cycle = Cycle::join('groups','cycles.group_id','=','groups.id')
            ->select('cycles.id','cycle','groups.group','start_date','end_date')
            ->where('status','=','A')
            ->where('group_id','=',$request->group_id)
            ->orderBy('cycles.id','desc')
            ->get();

            if (!isset($cycle[0]->id)) return response([],204);

            $loads = Load::join('cycles','loads.cycle_id','=','cycles.id')
            ->join('subjects','loads.subject_id','=','subjects.id')
            ->join('users','loads.user_id','=','users.id')
            ->join('schedules','loads.schedule_id','=','schedules.id')
            ->select(
                'loads.id',
                'subjects.subject',
                'subjects.description',
                'schedules.start_date',
                'schedules.end_date',
                'schedules.start_time',
                'schedules.end_time'
            )
            ->where('cycles.id',$cycle[0]->id)
            ->where('users.id',auth()->user()->id)
            ->where('subjects.status','D')
            ->get();
            
            return response()->json(["loads" => $loads, "current_cycle" => $cycle[0]], 200);

        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
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
        try{
            $load = Load::findOrFail($request->id);
            $load->user_id = $request->user_id;
            $load->cycle_id = $request->cycle_id;
            $load->subject_id = $request->subject_id;
            $load->schedule_id = $request->schedule_id;
            if($load->save()>=1){
                return response()->json(['status'=>'ok','data'=>$load],202);
            }
            $load->save();
        }catch(\Exception $e){
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
