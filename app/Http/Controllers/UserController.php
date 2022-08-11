<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Note;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getTeacher() {
        try {
            $teacher = User::select('users.id', 'users.name as teacher', 'users.last_name', 'users.code', 'users.status')
            ->where('users.role', '=', 'docente')
            ->orderBy('id','asc')->get();
            return $teacher;
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }

    public function getStudent() {
        try {
            $student = User::select('users.id', 'users.name as student', 'last_name', 'code')
            ->where('users.role', '=', 'alumno')
            ->orderBy('id','asc')->get();
            return $student;
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }
    public function getStudentA() {
        try {
            $student = Note::join('inscriptions', 'notes.inscription_id', '=', 'inscriptions.id')
                ->join('users', 'inscriptions.user_id', '=', 'users.id')
                ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
                ->join('subjects', 'Loads.subject_id', '=', 'subjects.id')
                ->select('notes.id',
                'users.name as student',
                'users.last_name',
                'users.code', 
                'subjects.subject',
                'notes.finalAverage',
                'notes.status',)
                ->where('notes.status', '=', 'Aprovado')
                ->orderBy('id','asc')->get();
            return $student;
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }
    public function getStudentR() {
        try {
            $student = Note::join('inscriptions', 'notes.inscription_id', '=', 'inscriptions.id')
                ->join('users', 'inscriptions.user_id', '=', 'users.id')
                ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
                ->join('subjects', 'Loads.subject_id', '=', 'subjects.id')
                ->select('notes.id',
                'users.name as student',
                'users.last_name',
                'users.code', 
                'subjects.subject',
                'notes.finalAverage',
                'notes.status',)
                ->where('notes.status', '=', 'Reprobado')
                ->orderBy('id','asc')->get();
            return $student;
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }
}
