<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Load;

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
            $load->status = $request->status;
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
                'cycles.cycle',
                'subjects.subject',
                'users.name as teacher',
                'users.last_name',
                'schedules.start_time',
                'schedules.end_time'
            )
            ->orderBy('id', 'asc')
            ->paginate(5)->onEachSide(1);
            return $loads;
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
    public function update(Request $request, $id)
    {
        //
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
