<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
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
            $notes = new Note();
            $notes->ev1 = $request->ev1;
            $notes->percentege1 = $request->percentege1;
            $notes->ev2 = $request->ev2;
            $notes->percentege2 = $request->percentege2;
            $notes->ev3 = $request->ev3;
            $notes->percentege3 = $request->percentege3;
            $notes->ev4 = $request->ev4;
            $notes->percentege4 = $request->percentege4;
            $notes->ev5 = $request->ev5;
            $notes->percentege5 = $request->percentege5;
            $notes->finalAverage = $request->finalAverage;
            $notes->status = $request->status;
            $notes->inscription_id = $request->inscription_id;
            if ($notes->save() >= 1) {
                return response()->json(['status' => 'ok', 'data' => $notes], 201);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
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
            $notes = Note::join('inscriptions', 'notes.inscription_id', '=', 'inscriptions.id')
                ->join('users', 'inscriptions.user_id', '=', 'users.id')
                ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
                ->join('subjects', 'Loads.subject_id', '=', 'subjects.id')
                ->select(
                    'notes.id',
                    'notes.ev1',
                    'notes.percentege1',
                    'notes.ev2',
                    'notes.percentege2',
                    'notes.ev3',
                    'notes.percentege3',
                    'notes.ev4',
                    'notes.percentege4',
                    'notes.ev5',
                    'notes.percentege5',
                    'notes.finalAverage',
                    'notes.status',
                    'users.name',
                    'users.last_name',
                    'users.code',
                    'subjects.subject'
                )
                ->orderBy('notes.id', 'asc')
                ->get();
            return $notes;
        } catch (\Exception $e) {
            return $e->getMessage();
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
