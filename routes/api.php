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

use App\Http\Controllers\PublicationController;

use App\Http\Controllers\PDFController;


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
    Route::post('/saveCiclo',[CycleController::class,'store']);
    Route::post('/saveAsignaturas',[SubjectController::class,'store']);
    Route::resource('/grupos', GroupController::class);
    Route::get('/getGrupos/{paginate?}', [GroupController::class, 'show']);
    Route::get('/getAsignaturas/{paginate?}', [SubjectController::class, 'show']);
    //Route::get('/ciclos/{paginate}', CycleController::class);
    Route::get('/getCiclos/{paginate?}',[CycleController::class,'show']);
    Route::resource('/horarios', ScheduleController::class);
    Route::get('/getHorarios/{paginate?}', [ScheduleController::class, 'show']); 
    Route::get('/getInscripciones', [InscriptionController::class, 'show']);
    Route::get('/getCargas', [LoadController::class, 'show']);
    Route::get('/getInscrip', [InscriptionController::class, 'getInscriptionsD']);
    Route::get('/getInscript', [InscriptionController::class, 'getInscriptionS']);
    Route::get('getDocentes/{paginate?}', [UserController::class, 'getTeacher']);
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
    Route::get('/getPaymentsS', [PaymentController::class, 'getPaymentsS']);
    Route::get('/getTeacher1', [UserController::class, 'getTeacher1']);
    Route::resource('/aplicante', ApplicantController::class);
    Route::get('/getApplicants', [ApplicantController::class, 'show']);
    Route::get('/getStudentsByYear', [UserController::class, 'getStudentsPerYear']);
    Route::get('/getCyclesReport', [CycleController::class, 'getCyclesReport']);
    Route::get('/getSubjectsReport', [SubjectController::class, 'getSubjectsReport']);
    Route::get('/getNotesReport', [NoteController::class, 'getNotesReport']);
    Route::get('/getAssistancesReport', [AssistanceController::class, 'getAssistances']);
    Route::put('/updateGroup', [GroupController::class, 'update']);
    Route::put('/updateSubject', [SubjectController::class, 'update']);
    Route::put('/updateCycle', [CycleController::class, 'update']);
    Route::put('/updateSchedule', [ScheduleController::class, 'update']);
    Route::put('/updateLoad', [LoadController::class, 'update']);
    Route::get('/cyclesPDF/pdf', [PDFController::class,'cyclesPDF']);
});

    
/*get
|--------------------------------------------------------------------------
| SECRETARIA Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for secretaria user
|
*/

Route::middleware(['auth:sanctum', 'secretaria'])->group(function(){
    
    Route::get('/getrates', [RateController::class, 'getrates']);
    Route::resource('/pagos', PaymentController::class);
    Route::post('/savePago',[PaymentController::class,'store']);
    Route::get('/getPagos', [PaymentController::class, 'show']);
    Route::get('/getTarifas/{paginate?}', [RateController::class, 'show']);
    Route::get('/getStudent', [UserController::class, 'getStudent']);
    Route::get('/getAplicante', [ApplicantController::class, 'show']);
    Route::delete('/deleteApplicant', [ApplicantController::class, 'destroy']);
    Route::post('/register', [RegisterController::class,'register']);
    Route::resource('/aplicante', ApplicantController::class);
    Route::post('/inscribir', [UserController::class, 'registerStudent']);
    Route::delete('/rechazar', [ApplicantController::class, 'destroy']);
    Route::get('/aplicantes-pendientes', [ApplicantController::class, 'getPendingApplicants']);
    Route::put('/updatePayment', [PaymentController::class, 'update']);
    Route::put('/updateRate', [RateController::class, 'update']);
    Route::put('/restore-c-access', [UserController::class, 'restorePass']);
    Route::put('/disable-user', [UserController::class, 'disableUser']);
    Route::get('/users/{role}', [UserController::class, 'getUsersByRole']);
    Route::post('/search-student', [UserController::class, 'getStudentsBySearch']);
    Route::get('/get-grupos/{paginate?}', [GroupController::class, 'show']);
    Route::get('/get-user-payments/{userId}', [PaymentController::class, 'getUserPayments']);
    Route::get('/getPaymentssolv', [PaymentController::class, 'getPaymentsS']);
    Route::get('/getAplicantes', [ApplicantController::class, 'show']);
    Route::get('/getEcclesiasticalInform', [ApplicantController::class, 'getEcclesiasticalInfo']);
    Route::get('/getMinisterialInform', [ApplicantController::class, 'getMinisterialInfo']);
    Route::get('/getStudentsYear', [UserController::class, 'getStudentsPerYear']);
    Route::post('/publicaciones', [PublicationController::class, 'store']);
    Route::get('/getpublicaciones', [PublicationController::class, 'show']);
    Route::delete('/deletePublication', [PublicationController::class, 'destroy']);
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
    Route::post('/saveAssistances',[AssistanceController::class,'store']);
    Route::get('/getAsistencia', [AssistanceController::class, 'show']);
    Route::resource('/notas', NoteController::class);
    Route::get('/getNota/{paginate?}', [NoteController::class, 'show']);
    Route::get('/getInscriptions', [InscriptionController::class, 'show']);  
    Route::put('/updateAssistance',[AssistanceController::class, 'update']);
    Route::put('/updateNote',[NoteController::class, 'update']);
    Route::get('/getAssistance', [AssistanceController::class, 'getAssistances']);
    Route::get('/getEstadoApr', [UserController::class, 'getStudentA']);
    Route::get('/getEstadoRep', [UserController::class, 'getStudentR']);
    Route::get('/students-notes/{idLoad}', [NoteController::class, 'studentsNotes']);
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
    Route::get('/get-student-info/{applicantId}', [ApplicantController::class, 'getApplicantInfo']);
    Route::get('/get-inscription', [InscriptionController::class, 'getStudentInscription']);
    Route::get('/inscription-cycles', [InscriptionController::class, 'getInscriptionCycles']);
    Route::post('/inscribe', [InscriptionController::class, 'store']);
    Route::get('/get-schedules/{cycleId}', [ScheduleController::class, 'getStudentSchedules']);

});


Route::get('/getUser', [AuthController::class, 'getLoggedUser'])->middleware('auth:sanctum');


// Open routes
Route::get('/getpublications', [PublicationController::class, 'show']);
Route::post('/aplicante', [ApplicantController::class, 'store']);
//routes basic level 
Route::get('/level', [SubjectController::class, 'levelbasic1']);
Route::get('/level2', [SubjectController::class, 'levelbasic2']);
Route::get('/level3', [SubjectController::class, 'levelbasic3']);
Route::get('/level4', [SubjectController::class, 'levelbasic4']);
//routes ministerial level
Route::get('/levelMinisterial', [SubjectController:: class, 'Ministerial1']);
Route::get('/levelMinisteria2', [SubjectController:: class, 'Ministerial2']);
//routes especialized level
Route::get('/MinisterioPas', [SubjectController::class, 'MinisterioPas']);
Route::get('/Misiones', [SubjectController::class, 'Misiones']);
Route::get('/EducacionCris',[SubjectController::class, 'EducacionCris']);
Route::get('/MinisterioJ',[SubjectController::class, 'MinisterioJ']);
Route::get('/PlantacionIg', [SubjectController::class, 'PlantacionIg']);
Route::get('/MinisterioU', [SubjectController::class, 'MinisterioU']);
Route::get('/MinisterioI', [SubjectController::class, 'MinisterioI']);


Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::any('{path}', function() {
    return response()->json([
        'message' => 'The specified route was not found'
    ], 404);
})->where('path', '.*');
