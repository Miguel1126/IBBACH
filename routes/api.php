<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\LoadController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\AssistanceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CycleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NoteController;


/*
|--------------------------------------------------------------------------
| ADMIN Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for admin user
|
*/

Route::middleware(['auth:sanctum', 'admin'])->group(function(){
    
    Route::post('/saveCarga',[LoadController::class,'store']);
    Route::resource('/grupos', GroupController::class);
    Route::get('/getGrupos', [GroupController::class, 'show']);
    Route::resource('/asignaturas', SubjectController::class);
    Route::get('/getAsignaturas', [SubjectController::class, 'show']);
    Route::resource('/ciclos', CycleController::class);
    Route::get('/getCiclos',[CycleController::class,'show']);
    Route::resource('/horarios', ScheduleController::class);
    Route::get('/getHorarios', [ScheduleController::class, 'show']); 
    Route::get('/getInscripciones', [InscriptionController::class, 'show']);
    Route::get('/getCargas', [LoadController::class, 'show']);
    Route::get('/getInscrip', [InscriptionController::class, 'getInscriptionsD']);
    Route::get('/getInscript', [InscriptionController::class, 'getInscriptionS']);
    Route::get('getDocentes', [UserController::class, 'getTeacher']);
    Route::get('/students', [UserController::class, 'getStudent']);
    Route::get('/getEstadoA', [UserController::class, 'getStudentA']);
    Route::get('/getEstadoR', [UserController::class, 'getStudentR']);
    Route::get('/getGrupoD', [UserController::class, 'getGroupD']);
    Route::get('/getGrupoS', [UserController::class, 'getGroupS']);
    Route::get('/getAdmin' , [UserController::class, 'getAdmin']);
    Route::get('/getSecre' , [UserController::class, 'getSecre']);
    Route::get('/getteachers' , [UserController::class, 'getteachers']);
    Route::get('/getStudents' , [UserController::class, 'getStudents']);
    Route::get('/getAplicantes', [ApplicantController::class, 'show']);
    Route::get('getNotas', [NoteController::class, 'show']);
    Route::get('/getAsistencias', [AssistanceController::class, 'show']);
    Route::get('/getPaymentsp', [PaymentController::class, 'getPaymentsP']);
    Route::get('/getPaymentsS', [PaymentController::class, 'getPaymentsS']);
    Route::get('/getTeacher1', [UserController::class, 'getTeacher1']);
    Route::resource('/aplicante', ApplicantController::class);
    Route::get('/getPersonalInfo', [ApplicantController::class, 'getPersonalInfo']);
    Route::get('/getEcclesiasticalInfo', [ApplicantController::class, 'getEcclesiasticalInfo']);
    Route::get('/getMinisterialInfo', [ApplicantController::class, 'getMinisterialInfo']);
    Route :: get('/getRate', [RateController::class, 'getRate']);
    Route::get('/getStudentsByYear', [UserController::class, 'getStudentsPerYear']);
});

    
/*
|--------------------------------------------------------------------------
| SECRETARIA Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for secretaria user
|
*/



Route::middleware(['auth:sanctum', 'secretaria'])->group(function(){
    
    Route::resource('/pagos', PaymentController::class);
    Route::get('/getPagos', [PaymentController::class, 'show']);
    Route::resource('/tarifas', RateController::class);
    Route::get('/getTarifas', [RateController::class, 'show']);
    Route::get('/getStudent', [UserController::class, 'getStudent']);
    Route::get('/getAplicante', [ApplicantController::class, 'show']);
    Route::post('/register', [RegisterController::class,'register']);
    Route::resource('/aplicante', ApplicantController::class);
    Route::post('/inscribir', [UserController::class, 'registerStudent']);
    Route::get('/aplicantes-pendientes', [ApplicantController::class, 'getPendingApplicants']);
});



/*
|--------------------------------------------------------------------------
| DOCENTE Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for docente user
|
*/

Route::middleware(['auth:sanctum', 'docente'])->group(function(){
    
    Route::resource('/asistencias', AssistanceController::class);
    Route::get('/getAsistencia', [AssistanceController::class, 'show']);
    Route::resource('/notas', NoteController::class);
    Route::get('/getNota', [NoteController::class, 'show']);
    Route::get('/getInscriptions', [InscriptionController::class, 'show']);  
});


/*
|--------------------------------------------------------------------------
| ALUMNO Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for alumno user
|
*/


Route::middleware(['auth:sanctum', 'alumno'])->group(function(){
    
    Route::get('students', [UserController::class, 'getStudent']);
    Route::get('/getCarga', [InscriptionController::class, 'getLoad']);
    Route::resource('/inscripciones', InscriptionController::class);
    Route::get('/getInscripcion', [InscriptionController::class, 'show']);
});




// Open routes

Route::post('/aplicante', [ApplicantController::class, 'store']);

Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::any('{path}', function() {
    return response()->json([
        'message' => 'The specified route was not found'
    ], 404);
})->where('path', '.*');
