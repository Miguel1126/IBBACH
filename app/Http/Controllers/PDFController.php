<?php

namespace App\Http\Controllers;

use App\Models\Assistance;
use App\Models\Cycle;
use App\Models\Inscription;
use App\Models\Load;
use App\Models\Note;
use App\Models\Payment;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Svg\Tag\Rect;

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
        return $pdf->stream('cycles.pdf');
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
        return $pdf->stream('assistances.pdf');
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
        return $pdf->stream('inscriptions.pdf');
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
        return $pdf->stream('inscriptions.pdf');
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
        return $pdf->stream('loads.pdf');
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
        return $pdf->stream('notes.pdf');
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
                'notes.result_status',
                'users.name',
                'users.last_name',
                'users.code',
                'subjects.subject',
                'notes.finalAverage',
                'notes.status',
                'cycles.cycle'
            )
            ->where('notes.result_status', '=', 'A')
            ->whereBetween('notes.created_at', [$date1, $date2])
            ->orderBy('notes.id', 'desc')->get();
        $pdf = \PDF::loadView("studentsRorAPDF", compact('students'));
        return $pdf->stream('studentsAPDF.pdf');
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
                'notes.result_status',
                'users.name',
                'users.last_name',
                'users.code',
                'subjects.subject',
                'notes.finalAverage',
                'notes.status',
                'cycles.cycle'
            )
            ->where('notes.result_status', '=', 'R')
            ->whereBetween('notes.created_at', [$date1, $date2])
            ->orderBy('notes.id', 'desc')->get();
        $pdf = \PDF::loadView("studentsRorAPDF", compact('students'));
        return $pdf->stream('studentsAPDF.pdf');
    }

    public function subjectsPDF(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        $subjects = Subject::select(
            'subjects.id',
            'subjects.subject',
            'subjects.created_at',
            'subjects.description',
            'subjects.uv',
            'subjects.level',
            'subjects.status'
        )
            ->whereBetween('subjects.created_at', [$date1, $date2])
            ->orderBy('id', 'desc')->get();
        $pdf = \PDF::loadView("subjectsPDF", compact('subjects'));
        return $pdf->stream('subjects.pdf');
    }

    public function paymentsPDF(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        $payments = Payment::join('users', 'payments.user_id', '=', 'users.id')
            ->join('rates', 'payments.rate_id', '=', 'rates.id')
            ->select(
                'payments.id',
                'payments.payment_date',
                'payments.paid_count',
                'payments.total',
                'payments.status',
                'payments.sourcharge',
                DB::raw("CONCAT(users.name,' ',users.last_name) AS student"),
                'rates.price',
                'payments.created_at'
            )
            ->where('payments.status', '=', 'S')
            ->whereBetween('payments.created_at', [$date1, $date2])
            ->orderBy('payments.id', 'desc')->get();
        $pdf = \PDF::loadView("paymentsPDF", compact('payments'));
        return $pdf->stream('payments.pdf');
    }

    public function teachersPDF(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        $users = User::select(
            'users.id',
            'users.name',
            'users.last_name',
            'users.code',
            'users.created_at',
            'users.status',
            'users.role'
        )
            ->where('users.role', '=', 'docente')
            ->whereBetween('users.created_at', [$date1, $date2])
            ->orderBy('users.id', 'desc')->get();
            $pdf = \PDF::loadView("usersPDF", compact('users'));
            return $pdf->stream('teachers.pdf');
    }

    public function secretaryPDF(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        $users = User::select(
            'users.id',
            'users.name',
            'users.last_name',
            'users.code',
            'users.created_at',
            'users.status',
            'users.role'
        )
            ->where('users.role', '=', 'secretaria')
            ->whereBetween('users.created_at', [$date1, $date2])
            ->orderBy('users.id', 'desc')->get();
            $pdf = \PDF::loadView("usersPDF", compact('users'));
            return $pdf->stream('secretary.pdf');
    }

    public function studentsPDF(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        $users = User::select(
            'users.id',
            'users.name',
            'users.last_name',
            'users.code',
            'users.created_at',
            'users.status',
            'users.role'
        )
            ->where('users.role', '=', 'alumno')
            ->whereBetween('users.created_at', [$date1, $date2])
            ->orderBy('users.id', 'desc')->get();
            $pdf = \PDF::loadView("usersPDF", compact('users'));
            return $pdf->stream('students.pdf');
    }

    public function adminsPDF(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        $users = User::select(
            'users.id',
            'users.name',
            'users.last_name',
            'users.code',
            'users.created_at',
            'users.status',
            'users.role'
        )
            ->where('users.role', '=', 'admin')
            ->whereBetween('users.created_at', [$date1, $date2])
            ->orderBy('users.id', 'desc')->get();
            $pdf = \PDF::loadView("usersPDF", compact('users'));
            return $pdf->stream('admins.pdf');
    }

    public function newUserPDF(Request $request) {
        $data = [
            "name" => $request->name,
            "code" => $request->code,
            "password" => $request->password,
        ];
        $pdf = \PDF::loadView("newUserPDF", compact('data'));
        return $pdf->stream('new-user.pdf');
    }
}
