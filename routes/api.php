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
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssistanceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CycleController;








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
Route::get('/aplicante/get', [ApplicantController::class, 'show']);

Route::resource('/grupos', GroupController::class);
Route::get('/grupos/get', [GroupController::class, 'show']);

Route::resource('/asignaturas', SubjectController::class);
Route::get('/asignaturas/get', [SubjectController::class, 'show']);

Route::resource('/inscripciones', InscriptionController::class);
Route::get('/inscripciones/get', [InscriptionController::class, 'show']); 

Route::resource('/horarios', ScheduleController::class);
Route::get('/horarios/get', [ScheduleController::class, 'show']); 

Route::resource('/tarifas', RateController::class);
Route::get('/tarifas/get', [RateController::class, 'show']);

Route::resource('/usuarios', UserController::class);
Route::get('/usuarios/get', [UserController::class, 'show']); 

Route::resource('/asistencias', AssistanceController::class);
Route::get('/asistencias/get', [AssistanceController::class, 'show']);

Route::resource('/pagos', PaymentController::class);
Route::get('/pagos/get', [PaymentController::class, 'show']);


Route::post('/cargas/save',[LoadController::class,'store']);
Route::get('/cargas/all',[LoadController::class,'show']);

Route::post('login', [AuthController::class,'login']);
Route::post('register', [RegisterController::class,'register']);

Route::resource('/ciclos', CycleController::class);
Route::get('/ciclos/get',[CycleController::class,'show']);
