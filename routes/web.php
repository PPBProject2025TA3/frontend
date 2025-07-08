<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\ComentarioController;
use App\Http\Middleware\AuthCustom;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/', [TareaController::class, 'index']);

Route::get('/logout', [AuthController::class, 'logout'])->middleware(AuthCustom::class);
Route::post('/tareas', [TareaController::class, 'store']);
Route::put('/tareas/{id}', [TareaController::class, 'update']);
Route::delete('/tareas/{id}', [TareaController::class, 'destroy']);
Route::post('/tareas/{id}/comentarios', [ComentarioController::class, 'store']);

Route::middleware(AuthCustom::class)->group(function () {
    Route::get('/tareas/create', [TareaController::class, 'create'])->middleware(AuthCustom::class);
    Route::get('/tareas/{id}/edit', [TareaController::class, 'edit']);
});

Route::get('/tareas/{id}', [TareaController::class, 'show']);

