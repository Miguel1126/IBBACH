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
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('/aplicante', ApplicantController::class);
Route::get('/getAplicante', [ApplicantController::class, 'show']);

Route::resource('/grupos', GroupController::class);
Route::get('/getGrupos', [GroupController::class, 'show']);

Route::resource('/asignaturas', SubjectController::class);
Route::get('/getAsignaturas', [SubjectController::class, 'show']);

Route::resource('/inscripciones', InscriptionController::class);
Route::get('/getInscripciones', [InscriptionController::class, 'show']); 
Route::get('/getCargas', [InscriptionController::class, 'getLoad']);
Route::get('/getInscrip', [InscriptionController::class, 'getInscriptionsD']);
Route::get('/getInscript', [InscriptionController::class, 'getInscriptionS']);

Route::resource('/horarios', ScheduleController::class);
Route::get('/getHorarios', [ScheduleController::class, 'show']); 

Route::resource('/tarifas', RateController::class);
Route::get('/tarifas/get', [RateController::class, 'show']);

Route::resource('/asistencias', AssistanceController::class);
Route::get('/getAsistencias', [AssistanceController::class, 'show']);

Route::resource('/pagos', PaymentController::class);
Route::get('/pagos/get', [PaymentController::class, 'show']);
Route::get('/getPaymentsp', [PaymentController::class, 'getPaymentsP']);
Route::get('/getPaymentsS', [PaymentController::class, 'getPaymentsS']);

Route::post('/cargas/save',[LoadController::class,'store']);
Route::get('/cargas/all',[LoadController::class,'show']);

Route::post('/login', [AuthController::class,'login']);
Route::post('/register', [RegisterController::class,'register']);

Route::resource('/ciclos', CycleController::class);
Route::get('/getCiclos',[CycleController::class,'show']);

Route::get('/getDocentes', [UserController::class, 'getTeacher']);
Route::get('/students', [UserController::class, 'getStudent']);
Route::get('/getEstadoA', [UserController::class, 'getStudentA']);
Route::get('/getEstadoR', [UserController::class, 'getStudentR']);
Route::get('/getGrupoD', [UserController::class, 'getGroupD']);
Route::get('/getGrupoS', [UserController::class, 'getGroupS']);
Route::get('/getAdmin' , [UserController::class, 'getAdmin']);
Route::get('/getSecre' , [UserController::class, 'getSecre']);
Route::get('/getteachers' , [UserController::class, 'getteachers']);
Route::get('/getStudents' , [UserController::class, 'getStudents']);

Route::resource('/notas', NoteController::class);
Route::get('/getNotas', [NoteController::class, 'show']);

Route::any('{path}', function() {
    return response()->json([
        'message' => 'The specified route was not found'
    ], 404);
})->where('path', '.*');
