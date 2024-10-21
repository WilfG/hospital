<?php

use App\Http\Controllers\API\CategoryExpensesAPIController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CategoryExpensesController;
use App\Http\Controllers\PatientsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('fetch-states', [PatientsController::class, 'fetchState']);
Route::post('fetch-cities', [PatientsController::class, 'fetchCity']);
Route::post('fetch-patients', [PatientsController::class, 'fetchPatientsTot']);
Route::post('fetch-sales', [PatientsController::class, 'fetchSalesTot']);
Route::get('appointments', [AppointmentController::class, 'fetchAppointment']);
Route::post('categoryExp', [CategoryExpensesAPIController::class, 'store']);
Route::get('categoryExpList', [CategoryExpensesAPIController::class, 'index']);
