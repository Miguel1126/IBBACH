<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use Illuminate\Http\Request;
use App\Models\Inscription;
use App\Models\Load;
use App\Models\Note;
use Illuminate\Support\Facades\DB;

class InscriptionController extends Controller
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
            $loadsLength = count($request->loads);

            $errors = 0;

            DB::beginTransaction();

            for ($i = 0; $i <= $loadsLength - 1; $i++) {
                if (!Inscription::where('load_id','=',$request->loads[$i])->where('user_id','=',auth()->user()->id)->exists()) {

                    $inscription = new Inscription();
                    $inscription->user_id = auth()->user()->id;
                    $inscription->load_id = $request->loads[$i];
                    if ($inscription->save() < 1) $errors++;
                    
                    $note = new Note();
                    $note->inscription_id = $inscription->id;
                    if ($note->save() < 1) $errors++;
                }
            }

            if ($errors === 0) {
                DB::commit();
                return response()->json(["message" => "Ciclo inscrito correctamente"],201);
            }
            else {
                DB::rollBack();
                return response()->json(["message" => "No se pudo inscribir el ciclo"],500);
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
    public function show()
    {
        try {
            $inscriptions = Inscription::join('users', 'inscriptions.user_id', '=', 'users.id')
            ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
            ->join('subjects', 'loads.subject_id', 'subjects.id')
            ->select(
                'inscriptions.id',
                'inscriptions.created_at',
                'inscriptions.status',
                'users.name',
                'users.last_name',
                'users.code',
                'subjects.subject',
                'subjects.description'
            )
            //->where('inscriptions.status', '=', 'inscrito')
            ->orderBy('id', 'desc')
            ->paginate(5)->onEachSide(1);
            return $inscriptions;
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }
    public function getInscriptionsD()
    {
        try {
            $inscriptions = Inscription::join('users', 'inscriptions.user_id', '=', 'users.id')
            ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
            ->join('subjects', 'loads.subject_id', '=','subjects.id')
            ->join('cycles', 'loads.cycle_id', '=', 'cycles.id')
            ->join('groups', 'cycles.group_id', '=', 'groups.id')
            ->select(
                'inscriptions.id',
                'inscriptions.created_at',
                'inscriptions.status',
                'cycles.cycle',
                'groups.group',
                'users.name',
                'users.last_name',
                'users.code',
                'subjects.subject',
                'subjects.description'
            )
            //->where('inscriptions.status', '=', 'inscrito')
            ->where('groups.group', '=', 'Diurno')
            ->orderBy('id', 'desc')
            ->paginate(5)->onEachSide(1);
            return $inscriptions;
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }
    public function getInscriptionS()
    {
        try {
            $inscriptions = Inscription::join('users', 'inscriptions.user_id', '=', 'users.id')
            ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
            ->join('subjects', 'loads.subject_id', '=','subjects.id')
            ->join('cycles', 'loads.cycle_id', '=', 'cycles.id')
            ->join('groups', 'cycles.group_id', '=', 'groups.id')
            ->select(
                'inscriptions.id',
                'inscriptions.created_at',
                'inscriptions.status',
                'cycles.cycle',
                'groups.group',
                'users.name',
                'users.last_name',
                'users.code',
                'subjects.subject',
                'subjects.description'
            )
            //->where('inscriptions.status', '=', 'inscrito')
            ->where('groups.group', '=', 'Sabatino')
            ->orderBy('id', 'desc')
            ->paginate(5)->onEachSide(1);
            return $inscriptions;
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }
    public function getLoad()
    {
        try {
            $loads = Load::join('users', 'loads.user_id', '=', 'users.id')
            ->join('cycles', 'loads.cycle_id', '=', 'cycles.id')
            ->join('subjects', 'loads.subject_id', '=', 'subjects.id')
            ->join('schedules', 'loads.schedule_id', '=', 'schedules.id')
            ->join('groups', 'cycles.group_id', '=', 'groups.id')
            ->select(
                'loads.id',
                'cycles.cycle',
                'groups.group',
                'subjects.subject',
                'subjects.description'
            )
            ->orderBy('id', 'desc')
            ->get();
            return $loads;
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }
    
    public function getStudentInscription() {
        try {
            $cycle = Cycle::join('groups','cycles.group_id','=','groups.id')
            ->select('cycles.id','cycle','groups.group','start_date','end_date')
            ->where('status','=','A')
            ->where('group_id','=',auth()->user()->group_id)
            ->orderBy('cycles.id','desc')
            ->get();

            if (!isset($cycle[0]->id)) return response([],204);

            $inscriptions = Inscription::join('loads', 'inscriptions.load_id', '=', 'loads.id')
            ->join('cycles','loads.cycle_id','=','cycles.id')
            ->select('cycles.id as cycle_id')
            ->where('inscriptions.user_id','=',auth()->user()->id)
            ->where('cycle_id','=', $cycle[0]->id)
            ->count();

            $subjects = Load::join('subjects','loads.subject_id','=','subjects.id')
            ->select('loads.id','subjects.id as subject_id','subjects.subject','subjects.description','subjects.uv')
            ->where('loads.status','=','D')
            ->where('loads.cycle_id', '=', $cycle[0]->id)
            ->get();
            
            if (count($subjects) < 1) return response([],204);

            if (count($subjects) === $inscriptions) return response()->json(["cycle" => $cycle],200);
            
            return response()->json(["cycle" => $cycle, "subjects" => $subjects],200);
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }
    
    public function getInscriptionCycles() {
        try {
            $cycles = Inscription::join('loads', 'inscriptions.load_id', '=', 'loads.id')
            ->join('cycles','loads.cycle_id','=','cycles.id')
            ->join('groups', 'cycles.group_id', '=', 'groups.id')
            ->select('cycles.id','cycle','groups.group','start_date','end_date')
            ->whereIn('cycles.status', ['A','F'])
            ->where('group_id','=',auth()->user()->group_id)
            ->where('inscriptions.user_id','=',auth()->user()->id)
            ->groupBy('cycles.cycle')
            ->orderBy('cycles.id', 'desc')
            ->get();
            return $cycles;
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
            $inscription = Inscription::findOrFail($request->id);
            $inscription->status = $request->status;
            $inscription-> user_id = $request-> user_id;
            $inscription-> load_id = $request-> load_id;
            if ($inscription->save()>=1) {
                return response()->json(['status'=>'OK','data'=>$inscription],202);
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
