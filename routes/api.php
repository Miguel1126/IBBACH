<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\RegisterController;

use App\Http\Controllers\SubjectController;

use App\Http\Controllers\LoadController;

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


Route::post('/cargas/save',[LoadController::class,'store']);
Route::get('/cargas/all',[LoadController::class,'show']);

Route::post('login', [AuthController::class,'login']);
Route::post('register', [RegisterController::class,'register']);
