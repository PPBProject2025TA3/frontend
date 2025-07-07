<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\ComentarioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rutas públicas (sin autenticación)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

// Ruta para logout (requiere autenticación)
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth.custom');

// Ruta pública para ver todas las tareas (o la home)
Route::get('/', [TareaController::class, 'index']);

// Ruta para crear tarea — requiere autenticación
Route::get('/tareas/create', [TareaController::class, 'create'])->middleware('auth.custom');

// Rutas protegidas con middleware auth.custom
Route::middleware('auth.custom')->group(function () {
    Route::post('/tareas', [TareaController::class, 'store']);
    Route::get('/tareas/{id}/edit', [TareaController::class, 'edit']);
    Route::put('/tareas/{id}', [TareaController::class, 'update']);
    Route::delete('/tareas/{id}', [TareaController::class, 'destroy']);
    Route::post('/tareas/{id}/comentarios', [ComentarioController::class, 'store']);
});

// Ruta pública para mostrar una tarea específica
// Esta debe ir al final para que no se confunda con otras rutas
Route::get('/tareas/{id}', [TareaController::class, 'show']);
