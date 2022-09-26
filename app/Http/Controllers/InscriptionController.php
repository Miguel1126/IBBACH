<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscription;
use App\Models\Load;

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
            $inscription = new Inscription();
            $inscription->registration_date = $request->registration_date;
            $inscription->status = $request->status;
            $inscription-> user_id = $request-> user_id;
            $inscription-> load_id = $request-> load_id;
            if ($inscription->save()>=1) {
                return response()->json(['status'=>'OK','data'=>$inscription],201);
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
                'inscriptions.registration_date',
                'inscriptions.status',
                'users.name',
                'users.last_name',
                'users.code',
                'subjects.subject',
                'subjects.description'
            )
            //->where('inscriptions.status', '=', 'inscrito')
            ->orderBy('id', 'asc')
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
                'inscriptions.registration_date',
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
            ->orderBy('id', 'asc')
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
                'inscriptions.registration_date',
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
            ->orderBy('id', 'asc')
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
            ->orderBy('group', 'asc')
            ->get();
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
    public function update(Request $request)
    {
        try {
            $inscription = Inscription::findOrFail($request->id);
            $inscription->registration_date = $request->registration_date;
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
