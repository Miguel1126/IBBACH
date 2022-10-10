<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assistance;


class AssistanceController extends Controller
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
            $assistance = new Assistance();
            $assistance->date = $request->date;
            //$assistance->status = $request->status;
            $assistance->note_id = $request->note_id;
            if ($assistance->save()>=1) {
                return response()->json(['status'=>'OK','data'=>$assistance],201);
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
            $assistance = Assistance::join('notes', 'assistances.note_id', '=', 'notes.id')
            ->join('inscriptions', 'notes.inscription_id', '=', 'inscriptions.id')
            ->join('users', 'inscriptions.user_id', '=', 'users.id')
            ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
            ->join('subjects', 'loads.subject_id', '=', 'subjects.id')
            ->select(
                'assistances.id', 
                'assistances.date', 
                'subjects.subject',
                'assistances.status', 
                'users.name',
                'users.last_name',
                'users.code'
            )
            ->orderBy('id', 'desc') ->paginate(5)->onEachSide(1);
            return $assistance;
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }

    public function getAssistances()
    {
        try {
            $assistance = Assistance::join('notes', 'assistances.note_id', '=', 'notes.id')
            ->join('inscriptions', 'notes.inscription_id', '=', 'inscriptions.id')
            ->join('users', 'inscriptions.user_id', '=', 'users.id')
            ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
            ->join('subjects', 'loads.subject_id', '=', 'subjects.id')
            ->select(
                'assistances.id', 
                'assistances.date', 
                'subjects.subject',
                'assistances.status', 
                'users.name',
                'users.last_name',
                'users.code'
            )
            ->orderBy('id', 'desc')
            ->paginate(5)->onEachSide(1);
            return $assistance;
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
            $assistance = Assistance:: findOrFail($request->id);
            $assistance->date = $request->date;
            $assistance->status = $request->status;
            $assistance->note_id = $request->note_id;
            if ($assistance->save()>=1) {
                return response()->json(['status'=>'OK','data'=>$assistance],202);
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
    public function destroy(Request $request)
    {
    }
}
