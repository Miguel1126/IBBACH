<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\User;
use App\Models\Note;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            $student = User::select('users.id', 'users.name as admin', 'users.last_name', 'users.code', 'users.status', 'role')
            ->where('users.role', '=', 'alumno')
            ->orderBy('id','asc')->get();
            return $student;
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
    public function getTeacher1() {
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

    public function getStudentsPerYear() {
        try {
            $currentYear = date('Y');

            $startYearDate = mktime(0,0,0,1,1,$currentYear);
            $endYearDate = mktime(0,0,0,12,31,$currentYear);

            $formatedSartYearDate = date("Y-m-d h:i:s", $startYearDate);
            $formatedEndYearDate = date("Y-m-d h:i:s", $endYearDate);

            $student = User::where('users.role', '=', 'alumno')
            ->whereBetween('users.created_at',[$formatedSartYearDate, $formatedEndYearDate])
            ->orderBy('id','asc')
            ->get();
            return $student;
        } 
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }

    public function registerStudent(Request $request) {
        try {

            $errors = 0;
            DB::beginTransaction();

            // Getting the applicant by the id
            $applicant = Applicant::join('personal_information', 'applicants.personal_information_id', '=', 'personal_information.id')
            ->select('personal_information.name', 'personal_information.last_name')
            ->where('applicants.id', '=', $request->applicant_id)
            ->get();

            $pass = $this->generatePassword();

            // Creating the new student user
            $newStudent = new User();
            $newStudent->name = $applicant[0]->name;
            $newStudent->last_name = $applicant[0]->last_name;
            $newStudent->code = $this->generateStudentCode($applicant[0]->name, $applicant[0]->last_name);
            $newStudent->password = Hash::make($pass);
            $newStudent->role = 'alumno';
            $newStudent->status = 'active';
            $newStudent->applicant_id = $request->applicant_id;
            if ($newStudent->save() <= 0) {
                $errors++;
            }

            $id = $request->applicant_id;
            $registeredApplicant = Applicant::findOrFail($id);
            $registeredApplicant->status = "I";
            if ($registeredApplicant->save() <= 0) {
                $errors++;
            }

            if($errors == 0) {
                DB::commit();
                return response()->json(["user" => $newStudent, "pass" => $pass], 201);
            }
            else {
                DB::rollBack();
                return response()->json(['message'=>'No se pudo registrar el alumno'],500);
            }

        } 
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }

    // Function to generate the student code
    private function generateStudentCode($firstName, $lastName) {
        $applicantNameFirstLetter = strtoupper(substr($firstName,0,1));
        $applicantLastNameFirstLetter = strtoupper(substr($lastName,0,1));
        $code = $applicantNameFirstLetter . $applicantLastNameFirstLetter . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);

        do {
            $applicantNameFirstLetter = strtoupper(substr($firstName,0,1));
            $applicantLastNameFirstLetter = strtoupper(substr($lastName,0,1));
            $code = $applicantNameFirstLetter . $applicantLastNameFirstLetter . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
        } while (User::where('code', '=', $code)->exists());

        return $code;
    }

    // Function to generate a random password
    private function generatePassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
}
