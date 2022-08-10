<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser() {
        $userRole = auth()->user()->role;
        if ($userRole === 'admin' || $userRole === 'secretaria' || $userRole === 'docente' || $userRole === 'estudiante') {
               return response()->json(["user" => auth()->user()]);
        }
	    else {
            return response()->json(['message' => 'No tienes autorización para ejecutar esta acción, inicia sesión en una cuenta válida'],401);
        }
    }

    public function getTeacher() {
        $userRole = auth()->user()->role;
        if ($userRole === 'admin') {
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
	    else {
            return response()->json(['message' => 'No tienes autorización para ejecutar esta acción, inicia sesión en una cuenta válida'],401);
        }
    }

    public function getStudent() {
        $userRole = auth()->user()->role;
        if ($userRole === 'secretaria' || $userRole === 'docente') {
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
	    else {
            return response()->json(['message' => 'No tienes autorización para ejecutar esta acción, inicia sesión en una cuenta válida'],401);
        }
    }
}
