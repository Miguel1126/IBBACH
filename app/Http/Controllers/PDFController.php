<?php

namespace App\Http\Controllers;

use App\Models\Assistance;
use App\Models\Cycle;
use App\Models\Inscription;
use App\Models\Load;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{

    public function cyclesPDF(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        $cycles = Cycle::join('groups', 'cycles.group_id', '=', 'groups.id')
            ->select(
                'cycles.id',
                'cycles.cycle',
                'cycles.start_date',
                'cycles.end_date',
                'cycles.status',
                'cycles.created_at',
                'groups.group'
            )
            ->whereBetween('cycles.created_at', [$date1, $date2])
            ->orderBy('cycles.id', 'desc')->get();
        $pdf = \PDF::loadView("cyclesPDF", compact('cycles'));
        return $pdf->download('cycles.pdf');
    }

    public function assistancesPDF(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        $assistances = Assistance::join('notes', 'assistances.note_id', '=', 'notes.id')
            ->join('inscriptions', 'notes.inscription_id', '=', 'inscriptions.id')
            ->join('users', 'inscriptions.user_id', '=', 'users.id')
            ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
            ->join('subjects', 'loads.subject_id', '=', 'subjects.id')
            ->select(
                'assistances.id',
                'assistances.date',
                'subjects.subject',
                'assistances.status',
                'assistances.created_at',
                'users.name',
                'users.last_name',
                'users.code'
            )
            ->whereBetween('assistances.created_at', [$date1, $date2])
            ->orderBy('assistances.id', 'desc')->get();
        $pdf = \PDF::loadView("assistancesPDF", compact('assistances'));
        return $pdf->download('assistances.pdf');
    }

    public function inscriptionsPDF(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        $inscriptions = Inscription::join('users', 'inscriptions.user_id', '=', 'users.id')
            ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
            ->join('subjects', 'loads.subject_id', '=', 'subjects.id')
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
            ->where('groups.group', '=', 'Diurno')
            ->whereBetween('inscriptions.created_at', [$date1, $date2])
            ->orderBy('inscriptions.id', 'desc')->get();
        $pdf = \PDF::loadView("inscriptionsPDF", compact('inscriptions'));
        return $pdf->download('inscriptions.pdf');
    }
    public function inscriptionPDF(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        $inscriptions = Inscription::join('users', 'inscriptions.user_id', '=', 'users.id')
            ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
            ->join('subjects', 'loads.subject_id', '=', 'subjects.id')
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
            ->where('groups.group', '=', 'Diurno')
            ->whereBetween('inscriptions.created_at', [$date1, $date2])
            ->orderBy('inscriptions.id', 'desc')->get();
        $pdf = \PDF::loadView("inscriptionsPDF", compact('inscriptions'));
        return $pdf->download('inscriptions.pdf');
    }

    public function loadsPDF(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
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
            ->whereBetween('loads.created_at', [$date1, $date2])
            ->orderBy('loads.id', 'desc')->get();
        $pdf = \PDF::loadView("loadsPDF", compact('loads'));
        return $pdf->download('loads.pdf');
    }

    public function notesPDF(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
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
                'notes.created_at'
            )
            ->whereBetween('notes.created_at', [$date1, $date2])
            ->orderBy('notes.id', 'desc')->get();
        $pdf = \PDF::loadView("notesPDF", compact('notes'));
        return $pdf->download('notes.pdf');
    }

    public function studentsAPDF(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        $students = Note::join('inscriptions', 'notes.inscription_id', '=', 'inscriptions.id')
            ->join('users', 'inscriptions.user_id', '=', 'users.id')
            ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
            ->join('subjects', 'Loads.subject_id', '=', 'subjects.id')
            ->join('cycles', 'loads.cycle_id', '=', 'cycles.id')
            ->select(
                'notes.id',
                'users.name as student',
                'users.last_name',
                'users.code',
                'subjects.subject',
                'notes.finalAverage',
                'notes.status',
                'cycles.cycle'
            )
            ->where('notes.status', '=', 'A')
            ->whereBetween('notes.created_at', [$date1, $date2])
            ->orderBy('notes.id', 'desc')->get();
        $pdf = \PDF::loadView("studentsRorAPDF", compact('students'));
        return $pdf->download('studentsAPDF.pdf');
    }

    public function studentsRPDF(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        $students = Note::join('inscriptions', 'notes.inscription_id', '=', 'inscriptions.id')
            ->join('users', 'inscriptions.user_id', '=', 'users.id')
            ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
            ->join('subjects', 'Loads.subject_id', '=', 'subjects.id')
            ->join('cycles', 'loads.cycle_id', '=', 'cycles.id')
            ->select(
                'notes.id',
                'users.name',
                'users.last_name',
                'users.code',
                'subjects.subject',
                'notes.finalAverage',
                'notes.status',
                'cycles.cycle'
            )
            ->where('notes.status', '=', 'R')
            ->whereBetween('notes.created_at', [$date1, $date2])
            ->orderBy('notes.id', 'desc')->get();
        $pdf = \PDF::loadView("studentsRorAPDF", compact('students'));
        return $pdf->download('studentsAPDF.pdf');
    }
}
