<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cycle;
use App\Models\Group;

class CycleController extends Controller
{

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
            $cycle = new Cycle();
            if (Cycle::where('cycle', '=', $request->input('cycle'))->where('group_id', '=', $request->input('group_id'))->exists()) {
                return response()->json(["message" => "El ciclo ya existe"], 302);
            } else {
                $cycle->cycle = $request->cycle;
                $cycle->start_date = $request->start_date;
                $cycle->end_date = $request->end_date;
                $cycle->group_id = $request->group_id;
                if ($cycle->save() >= 1) {
                    return response()->json(['status' => 'OK', 'data' => $cycle], 201);
                }
            }
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
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
                $cycle = Cycle::join('groups', 'cycles.group_id', '=', 'groups.id')
                    ->select('cycles.id', 'cycles.cycle', 'cycles.start_date', 'cycles.end_date', 'cycles.status', 'groups.id as groupId', 'groups.group')
                    ->orderBy('id', 'desc')
                    ->paginate(5)->onEachSide(1);
                return $cycle;
            } else if (!$paginate) {
                $cycle = Cycle::join('groups', 'cycles.group_id', '=', 'groups.id')
                    ->select('cycles.id', 'cycles.cycle', 'cycles.start_date', 'cycles.end_date', 'cycles.status', 'groups.group')
                    ->orderBy('id', 'desc')
                    ->get();
                return $cycle;
            } else {
                return response()->json(["message" => "Argument '" . $paginate . "' does not exist"], 404);
            }
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getCyClesReport()
    {
        try {
            $cycle = Cycle::join('groups', 'cycles.group_id', '=', 'groups.id')
                ->select('cycles.id', 'cycles.cycle', 'cycles.start_date', 'cycles.end_date', 'cycles.status', 'groups.group')
                ->orderBy('id', 'desc')
                ->paginate(5)->onEachSide(1);
            return $cycle;
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
    
    public function getCurrentCycle(Request $request) {
        try {
            $cycle = Cycle::join('groups','cycles.group_id','=','groups.id')
            ->select('cycles.id','cycle','groups.group','start_date','end_date')
            ->where('status','=','A')
            ->where('group_id','=',$request->group_id)
            ->orderBy('cycles.id','desc')
            ->get();

            if (!isset($cycle[0]->id)) return response([],204);

            return $cycle[0]->id;

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
        try {
            if ($request->status === "A" && Cycle::where("status","A")->where("group_id",$request->group_id)->exists()) {
                return response()->json(["message" => "No pueden haber 2 ciclos de la misma modalidad activos a la vez"],409);
            }

            $cycle = Cycle::findOrFail($request->id);
            $cycle->cycle = $request->cycle;
            $cycle->start_date = $request->start_date;
            $cycle->end_date = $request->end_date;
            $cycle->group_id = $request->group_id;
            $cycle->status = $request->status;
            if ($cycle->save() >= 1) {
                return response()->json(['status' => 'ok', 'data' => $cycle], 202);
            }
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
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
