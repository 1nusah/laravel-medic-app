<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;


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
    Route::post('/', [AppointmentController::class, 'create']);
    Route::get('/', [AppointmentController::class, 'index']);
    Route::patch('/{id}/status', [AppointmentController::class, 'updateAppointmentStatus']);
    Route::patch('/{id}/assign-doctor', [AppointmentController::class, 'assignDoctor']);
    Route::put('/{id}', [AppointmentController::class, 'updateAppointmentDetails']);
    Route::get('/{id}', [AppointmentController::class, 'getAppointmentDetails']);
});
