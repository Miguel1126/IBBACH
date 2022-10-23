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

    public function getTeacher($paginate = null)
    {
        try {
            if ($paginate === 'paginate') {
                $teacher = User::select('users.id', 'users.name as teacher', 'users.last_name', 'users.code', 'users.status')
                    ->where('users.role', '=', 'docente')
                    ->orderBy('id', 'desc')->paginate(5)->onEachSide(1);
                return $teacher;
            } else if (!$paginate) {
                $teacher = User::select('users.id', 'users.name as teacher', 'users.last_name', 'users.code', 'users.status')
                    ->where('users.role', '=', 'docente')
                    ->orderBy('id', 'desc')
                    ->get();
                return $teacher;
            } else {
                return response()->json(["message" => "Argument '" . $paginate . "' does not exist"], 404);
            }
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getStudent()
    {
        try {
            $student = User::join('applicants', 'users.applicant_id', '=', 'applicants.id')
                ->join('personal_information', 'applicants.personal_information_id', '=', 'personal_information.id')
                ->select(
                    'users.id',
                    DB::raw("CONCAT(users.name,' ',users.last_name) AS student"),
                    'applicants.img',
                    'personal_information.phone',
                    'personal_information.email',
                    'personal_information.address',
                    'users.tuition',
                    'users.code',
                )
                ->where('users.role', '=', 'alumno')
                ->where('users.status', '=', 'activo')
                ->orderBy('id', 'desc')->get();
            return $student;
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getStudentsBySearch(Request $request) {
        try {
            $student = User::join('groups', 'users.group_id', 'groups.id')
                ->join('applicants', 'users.applicant_id', '=', 'applicants.id')
                ->join('personal_information', 'applicants.personal_information_id', '=', 'personal_information.id')
                ->select(
                    'users.id',
                    DB::raw("CONCAT(users.name,' ',users.last_name) AS student"),
                    'applicants.img',
                    'personal_information.phone',
                    'personal_information.email',
                    'personal_information.address',
                    'groups.group',
                    'users.paid_months',
                    'users.code',
                )
                ->where('users.role', '=', 'alumno')
                ->where('users.status', '=', 'activo')
                ->where('groups.id', '=', $request->groupId)
                ->where(DB::raw("CONCAT(users.name,' ',users.last_name)"),'LIKE',"%{$request->userName}%")
                ->get();
            return $student;
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getteachers()
    {
        try {
            $teacher = User::select('users.id', 'users.name as teacher', 'users.last_name', 'users.code', 'users.status', 'role')
                ->where('users.role', '=', 'docente')
                ->orderBy('id', 'desc')->paginate(5)->onEachSide(1);
            return $teacher;
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getStudents()
    {
        try {
            $student = User::select('users.id', 'users.name as student', 'users.last_name', 'users.code', 'users.status', 'role')
                ->where('users.role', '=', 'alumno')
                ->orderBy('id', 'desc')->paginate(5)->onEachSide(1);
            return $student;
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getAdmin()
    {
        try {
            $teacher = User::select('users.id', 'users.name as admin', 'users.last_name', 'users.code', 'users.status', 'role')
                ->where('users.role', '=', 'admin')
                ->orderBy('id', 'desc')->paginate(5)->onEachSide(1);
            return $teacher;
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getSecre()
    {
        try {
            $teacher = User::select('users.id', 'users.name as secretary', 'users.last_name', 'users.code', 'users.status', 'role')
                ->where('users.role', '=', 'secretaria')
                ->orderBy('id', 'desc')->paginate(5)->onEachSide(1);
            return $teacher;
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
    public function getStudentA()
    {
        try {
            $student = Note::join('inscriptions', 'notes.inscription_id', '=', 'inscriptions.id')
                ->join('users', 'inscriptions.user_id', '=', 'users.id')
                ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
                ->join('subjects', 'Loads.subject_id', '=', 'subjects.id')
                ->select(
                    'notes.id',
                    'users.name as student',
                    'users.last_name',
                    'users.code',
                    'subjects.subject',
                    'notes.finalAverage',
                    'notes.status',
                    'notes.result_status'
                )
                ->where('notes.result_status', '=', 'A')
                ->orderBy('id', 'desc')->paginate(5)->onEachSide(1);
            return $student;
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
    public function getTeacher1()
    {
        try {
            $teacher = User::select('users.id', 'users.name as teacher', 'users.last_name', 'users.code', 'users.status', 'role')
                ->where('users.role', '=', 'docente')
                ->orderBy('id', 'desc')->get();
            return $teacher;
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
    public function getStudentR()
    {
        try {
            $student = Note::join('inscriptions', 'notes.inscription_id', '=', 'inscriptions.id')
                ->join('users', 'inscriptions.user_id', '=', 'users.id')
                ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
                ->join('subjects', 'Loads.subject_id', '=', 'subjects.id')
                ->select(
                    'notes.id',
                    'users.name as student',
                    'users.last_name',
                    'users.code',
                    'subjects.subject',
                    'notes.finalAverage',
                    'notes.status',
                    'notes.result_status'
                )
                ->where('notes.result_status', '=', 'R')
                ->orderBy('id', 'desc')->paginate(5)->onEachSide(1);
            return $student;
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    //get student for group
    public function getGroupD()
    {
        try {
            $inscriptions = Inscription::join('users', 'inscriptions.user_id', '=', 'users.id')
                ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
                ->join('cycles', 'loads.cycle_id', '=', 'cycles.id')
                ->join('groups', 'cycles.group_id', '=', 'groups.id')
                ->select(
                    'inscriptions.id',
                    'users.name',
                    'users.last_name',
                    'users.code',
                    'groups.group'
                )
                ->where('groups.group', '=', 'Diurno')
                ->orderBy('id', 'desc')
                ->get();
            return $inscriptions;
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
    public function getGroupS()
    {
        try {
            $inscriptions = Inscription::join('users', 'inscriptions.user_id', '=', 'users.id')
                ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
                ->join('cycles', 'loads.cycle_id', '=', 'cycles.id')
                ->join('groups', 'cycles.group_id', '=', 'groups.id')
                ->select(
                    'inscriptions.id',
                    'users.name',
                    'users.last_name',
                    'users.code',
                    'groups.group'
                )
                ->where('groups.group', '=', 'Sabatino')
                ->orderBy('id', 'desc')
                ->get();
            return $inscriptions;
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getStudentsPerYear()
    {
        try {
            $currentYear = date('Y');

            $startYearDate = mktime(0, 0, 0, 1, 1, $currentYear);
            $endYearDate = mktime(0, 0, 0, 12, 31, $currentYear);

            $formatedSartYearDate = date("Y-m-d h:i:s", $startYearDate);
            $formatedEndYearDate = date("Y-m-d h:i:s", $endYearDate);

            $student = User::where('users.role', '=', 'alumno')
                ->whereBetween('users.created_at', [$formatedSartYearDate, $formatedEndYearDate])
                ->orderBy('id', 'desc')
                ->paginate(5)->onEachSide(1);
            return $student;
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function registerStudent(Request $request)
    {
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
            $newStudent->group_id = $request->groupId;
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

            if ($errors == 0) {
                DB::commit();
                return response()->json(["user" => $newStudent, "pass" => $pass], 201);
            } else {
                DB::rollBack();
                return response()->json(['message' => 'No se pudo registrar el alumno'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getUsersByRole($role = null)
    {
        try {
            if ($role === 'admin') {
                $admin = User::select('users.id', 'users.name', 'users.last_name', 'users.code', 'users.created_at')
                    ->where('users.role', '=', 'admin')
                    ->where('users.status', '=', 'activo')
                    ->orderBy('id', 'desc')
                    ->paginate(5)->onEachSide(1);
                return $admin;
            } else if ($role === 'secretaria') {
                $admin = User::select('users.id', 'users.name', 'users.last_name', 'users.code', 'users.created_at')
                    ->where('users.role', '=', 'secretaria')
                    ->where('users.status', '=', 'activo')
                    ->orderBy('id', 'desc')
                    ->paginate(5)->onEachSide(1);
                return $admin;
            } else if ($role === 'docente') {
                $admin = User::select('users.id', 'users.name', 'users.last_name', 'users.code', 'users.created_at')
                    ->where('users.role', '=', 'docente')
                    ->where('users.status', '=', 'activo')
                    ->orderBy('id', 'desc')
                    ->paginate(5)->onEachSide(1);
                return $admin;
            } else if ($role === 'alumno') {
                $admin = User::select('users.id', 'users.name', 'users.last_name', 'users.code', 'users.created_at')
                    ->where('users.role', '=', 'alumno')
                    ->where('users.status', '=', 'activo')
                    ->orderBy('id', 'desc')
                    ->paginate(5)->onEachSide(1);
                return $admin;
            } else if (!$role) {
                return response()->json(["message" => "Argument in path needed"], 204);
            } else {
                return response()->json(["message" => "Argument '" . $role . "' does not exist"], 404);
            }
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function restorePass(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);

            $newPass = $this->generatePassword();

            $user->password = Hash::make($newPass);

            if ($user->save() > 0) {
                return response()->json(["user" => $user, "pass" => $newPass], 200);
            }
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 304);
        }
    }

    public function disableUser(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);

            if ($user->role === "secretaria") {
                $activeSecretaries = User::where("role", "=", "secretaria")->where("status", "=", "activo")->count();
                if ($activeSecretaries < 2) {
                    return response()->json(["message" => "This user cannot be disabled"], 403);
                }
            }

            $user->status = "inactivo";

            if ($user->save() > 0) {
                return response()->json(["message" => "user disabled successfully"], 200);
            }
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 304);
        }
    }

    // Function to generate the student code
    private function generateStudentCode($firstName, $lastName)
    {
        $applicantNameFirstLetter = strtoupper(substr($firstName, 0, 1));
        $applicantLastNameFirstLetter = strtoupper(substr($lastName, 0, 1));
        $code = $applicantNameFirstLetter . $applicantLastNameFirstLetter . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);

        do {
            $applicantNameFirstLetter = strtoupper(substr($firstName, 0, 1));
            $applicantLastNameFirstLetter = strtoupper(substr($lastName, 0, 1));
            $code = $applicantNameFirstLetter . $applicantLastNameFirstLetter . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
        } while (User::where('code', '=', $code)->exists());

        return $code;
    }

    // Function to generate a random password
    private function generatePassword()
    {
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
