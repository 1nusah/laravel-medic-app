<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('users')->group(function () {
    Route::post('/create', [UserController::class, 'createUser']);
    Route::get('/', [UserController::class, 'findUsers']);
    Route::get('/{id}', [UserController::class, 'findUser']);
    Route::delete('/{id}', [UserController::class, 'deleteUser']);
});


Route::prefix('organizations')->group(function () {
    Route::get('/', [OrganizationController::class, 'findOrganizations']);
    Route::get('/{id}', [OrganizationController::class, 'fetchOrganization']);
    Route::delete('/{id}', [OrganizationController::class, 'deleteOrganization']);
    Route::post('/', [OrganizationController::class, 'create']);
});


Route::prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'findRoles']);
    Route::get('/{id}', [RoleController::class, 'findRole']);
    Route::delete('/{id}', [RoleController::class, 'deleteRole']);
    Route::post('/', [RoleController::class, 'create']);
});

Route::prefix('appointments')->group(function () {
    Route::post('/', [AppointmentController::class, 'createNewAppointment']);
    Route::get('/', [AppointmentController::class, 'findAppointments']);
    Route::patch('/{appointmentId}/status', [AppointmentController::class, 'updateAppointmentStatus']);
    Route::patch('/{appointmentId}/assign-doctor', [AppointmentController::class, 'assignDoctor']);
    Route::put('/{appointmentId}', [AppointmentController::class, 'updateAppointmentDetails']);
    Route::get('/{appointmentId}', [AppointmentController::class, 'getAppointmentDetails']);
});

Route::prefix('diagnoses')->group(function () {
    Route::post('/', [DiagnosisController::class, 'createDiagnosis']);
    Route::get('/', [DiagnosisController::class, 'findDiagnosis']);
    Route::delete('/{diagnosisId}', [DiagnosisController::class, 'deleteDiagnosis']);
    Route::put('/{diagnosisId}', [DiagnosisController::class, 'updateDiagnosis']);
});


