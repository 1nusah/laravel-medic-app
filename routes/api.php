<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('users')->group(function () {
    Route::post('/create',[UserController::class,'createUser']);
    Route::get('/', [UserController::class, 'findUsers']);
    Route::get('/{id}', [UserController::class, 'findUser']);
    Route::delete('/{id}', [UserController::class, 'deleteUser']);
});
