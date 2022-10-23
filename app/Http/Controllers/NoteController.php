<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use App\Models\Inscription;
use App\Models\Load;
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
            $notes = Note::join('inscriptions', 'notes.inscription_id', '=', 'inscriptions.id')
                ->join('users', 'inscriptions.user_id', '=', 'users.id')
                ->select(
                    'notes.id',
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
                    'notes.result_status',
                    'notes.status',
                )
                ->where('inscriptions.load_id', '=', $loadId)
                ->get();

            $load = Load::join('cycles', 'loads.cycle_id', '=', 'cycles.id')
                ->join('groups', 'cycles.group_id', '=', 'groups.id')
                ->join('subjects', 'loads.subject_id', '=', 'subjects.id')
                ->select(
                    'cycles.cycle',
                    'subjects.subject',
                    'groups.group',
                )
                ->where('loads.id', $loadId)
                ->get();

            if (!isset($load[0])) return response()->json([], 204);

            return response()->json(["notes" => $notes, "load" => isset($load[0]) ? $load[0] : []], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function studentNotes($cycleId)
    {
        try {
            $notes = Note::join('inscriptions', 'notes.inscription_id', '=', 'inscriptions.id')
                ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
                ->join('subjects','loads.subject_id','=','subjects.id')
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
                    'notes.result_status',
                    'subjects.subject'
                )
                ->where('inscriptions.user_id', auth()->user()->id)
                ->where('loads.cycle_id', '=', $cycleId)
                ->where('notes.status','A')
                ->get();

            return $notes;
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function publishNotes(Request $request)
    {
        try {
            $notes = $request->notes;
            for ($i = 0; $i < count($notes); $i++) {
                $note = Note::findOrFail($notes[$i]['id']);
                $note->status = "A";
                $note->save();
            }

            return response("Notes published successfully", 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $notes = $request->notes;
            for ($i = 0; $i < count($notes); $i++) {
                $note = Note::findOrFail($notes[$i]['id']);
                $note->ev1 = $notes[$i]['ev1'];
                $note->percentege1 = $notes[$i]['percentege1'];
                $note->ev2 = $notes[$i]['ev2'];
                $note->percentege2 = $notes[$i]['percentege2'];
                $note->ev3 = $notes[$i]['ev3'];
                $note->percentege3 = $notes[$i]['percentege3'];
                $note->ev4 = $notes[$i]['ev4'];
                $note->percentege4 = $notes[$i]['percentege4'];
                $note->ev5 = $notes[$i]['ev5'];
                $note->percentege5 = $notes[$i]['percentege5'];
                $note->finalAverage = $notes[$i]['finalAverage'];
                $note->result_status = $notes[$i]['result_status'];
                $note->save();
            }

            return response("Notes updated successfully", 200);
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
