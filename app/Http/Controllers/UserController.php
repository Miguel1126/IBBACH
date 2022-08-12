<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Note;
use App\Models\Inscription;
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
            $student = User::select('users.id', 'users.name as student', 'users.last_name', 'users.code', 'users.status')
            ->where('users.role', '=', 'alumno')
            ->orderBy('id','asc')->get();
            return $student;
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }

    public function getteachers() {
        try {
            $teacher = User::select('users.id', 'users.name as admin', 'users.last_name', 'users.code', 'users.status', 'role')
            ->where('users.role', '=', 'docente')
            ->orderBy('id','asc')->get();
            return $teacher;
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }

    public function getStudents() {
        try {
            $teacher = User::select('users.id', 'users.name as admin', 'users.last_name', 'users.code', 'users.status', 'role')
            ->where('users.role', '=', 'alumno')
            ->orderBy('id','asc')->get();
            return $teacher;
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }

    public function getAdmin() {
        try {
            $teacher = User::select('users.id', 'users.name as admin', 'users.last_name', 'users.code', 'users.status', 'role')
            ->where('users.role', '=', 'admin')
            ->orderBy('id','asc')->get();
            return $teacher;
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }

    public function getSecre() {
        try {
            $teacher = User::select('users.id', 'users.name as secretary', 'users.last_name', 'users.code', 'users.status', 'role')
            ->where('users.role', '=', 'secretaria')
            ->orderBy('id','asc')->get();
            return $teacher;
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

    //get student for group
    public function getGroupD(){
        try {
            $inscriptions = Inscription::join('users', 'inscriptions.user_id', '=', 'users.id')
            ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
            ->join('cycles', 'loads.cycle_id', '=', 'cycles.id')
            ->join('groups', 'cycles.group_id', '=', 'groups.id')
            ->select(
                'inscriptions.id',
                'inscriptions.registration_date',
                'users.name',
                'users.last_name',
                'users.code',
                'groups.group'
            )
            ->where('groups.group', '=', 'Diurno')
            ->orderBy('id', 'asc')
            ->get();
            return $inscriptions;
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }
    public function getGroupS(){
        try {
            $inscriptions = Inscription::join('users', 'inscriptions.user_id', '=', 'users.id')
            ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
            ->join('cycles', 'loads.cycle_id', '=', 'cycles.id')
            ->join('groups', 'cycles.group_id', '=', 'groups.id')
            ->select(
                'inscriptions.id',
                'inscriptions.registration_date',
                'users.name',
                'users.last_name',
                'users.code',
                'groups.group'
            )
            ->where('groups.group', '=', 'Sabatino')
            ->orderBy('id', 'asc')
            ->get();
            return $inscriptions;
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }
}
