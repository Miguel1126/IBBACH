<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getTeacher() {
        try {
            $teacher = User::select('users.id', 'users.name as teacher')
            ->where('users.role', '=', 'docente')
            ->orderBy('id','asc')->get();
            return $teacher;
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getStudent() {
        try {
            $student = User::select('users.id', 'users.name as student')
            ->where('users.role', '=', 'alumno')
            ->orderBy('id','asc')->get();
            return $student;
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
