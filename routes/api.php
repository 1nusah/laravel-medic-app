<?php

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
