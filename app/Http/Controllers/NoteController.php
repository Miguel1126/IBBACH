<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use App\Models\Inscription;
use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\DB;

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
                $notes = Note::join('inscriptions', 'notes.inscription_id', '=', 'inscriptions.id')
                    ->join('users', 'inscriptions.user_id', '=', 'users.id')
                    ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
                    ->join('subjects', 'Loads.subject_id', '=', 'subjects.id')
                    ->join('cycles', 'loads.cycle_id', '=', 'cycles.id')
                    ->join('groups', 'cycles.group_id', '=', 'groups.id')
                    ->select(
                        'notes.id',
                        'cycles.cycle',
                        'subjects.subject',
                        'users.name',
                        'users.last_name',
                        'users.code',
                        'groups.group',
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
                    )
                    ->orderBy('notes.id', 'desc')->paginate(5)->onEachSide(1);
                return $notes;
            } else if (!$paginate) {
                $notes = Note::join('inscriptions', 'notes.inscription_id', '=', 'inscriptions.id')
                    ->join('users', 'inscriptions.user_id', '=', 'users.id')
                    ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
                    ->join('subjects', 'Loads.subject_id', '=', 'subjects.id')
                    ->join('cycles', 'loads.cycle_id', '=', 'cycles.id')
                    ->join('groups', 'cycles.group_id', '=', 'groups.id')
                    ->select(
                        'notes.id',
                        'cycles.cycle',
                        'subjects.subject',
                        'users.name',
                        'users.last_name',
                        'users.code',
                        'groups.group',
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
                    )
                    ->orderBy('notes.id', 'desc')
                    ->get();
                return $notes;
            } else {
                return response()->json(["message" => "Argument '" . $paginate . "' does not exist"], 404);
            }
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getNotesReport()
    {
        try {
            $notes = Note::join('inscriptions', 'notes.inscription_id', '=', 'inscriptions.id')
                ->join('users', 'inscriptions.user_id', '=', 'users.id')
                ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
                ->join('subjects', 'Loads.subject_id', '=', 'subjects.id')
                ->join('cycles', 'loads.cycle_id', '=', 'cycles.id')
                ->join('groups', 'cycles.group_id', '=', 'groups.id')
                ->select(
                    'notes.id',
                    'cycles.cycle',
                    'subjects.subject',
                    'users.name',
                    'users.last_name',
                    'users.code',
                    'groups.group',
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
                )
                ->orderBy('notes.id', 'desc')
                ->paginate(5)->onEachSide(1);
            return $notes;
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getStudentNotes()
    {
        try {
            $cycle = Cycle::join('groups', 'cycles.group_id', '=', 'groups.id')
                ->select('cycles.id', 'cycle', 'groups.group', 'start_date', 'end_date')
                ->where('status', '=', 'A')
                ->where('group_id', '=', auth()->user()->group_id)
                ->orderBy('cycles.id', 'desc')
                ->get();

            if (!isset($cycle[0]->id)) return response([], 204);

            $inscriptions = Inscription::join('loads', 'inscriptions.load_id', '=', 'loads.id')
                ->join('cycles', 'loads.cycle_id', '=', 'cycles.id')
                ->select('inscriptions.id')
                ->where('inscriptions.user_id', '=', auth()->user()->id)
                ->where('cycles.id', '=', $cycle[0]->id)
                ->orderBy('cycles.id', 'desc')
                ->get();

            $arrayIdInscriptions = [];

            for ($i = 0; $i <= count($inscriptions) - 1; $i++) {
                array_push($arrayIdInscriptions, $inscriptions[$i]->id);
            }

            $notes = Note::whereIn('inscription_id', $arrayIdInscriptions)
                ->orderBy('id', 'desc')
                ->get();

            return $notes;
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function studentsNotes($loadId)
    {
        try {
            $notes = Note::join('inscriptions','notes.inscription_id','=','inscriptions.id')
            ->join('users','inscriptions.user_id','=','users.id')
            ->select(
                DB::raw("CONCAT(users.name,' ',users.last_name) AS student"),
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
            )
            ->where('inscriptions.load_id','=',$loadId)
            ->get();

            return $notes;

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
            $notes = Note::findOrFail($request->id);
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
                return response()->json(['status' => 'ok', 'data' => $notes], 202);
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
