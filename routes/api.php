<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupController;
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

//Route::resource('/grupos', GroupController::class);
Route::get('/grupos/get', [GroupController::class, 'show']);

Route::post('/cargas/save',[LoadController::class,'store']);
Route::get('/cargas/all',[LoadController::class,'show']);