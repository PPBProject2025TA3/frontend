<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rutas públicas
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout']);

// Tareas públicas
Route::get('/', [TareaController::class, 'index']);
Route::get('/tareas/{id}', [TareaController::class, 'show']);

// Tareas autenticado
Route::middleware('auth.custom')->group(function () {
    Route::get('/tareas/create', [TareaController::class, 'create']);
    Route::post('/tareas', [TareaController::class, 'store']);
    Route::get('/tareas/{id}/edit', [TareaController::class, 'edit']);
    Route::put('/tareas/{id}', [TareaController::class, 'update']);
    Route::delete('/tareas/{id}', [TareaController::class, 'destroy']);

    // Comentarios
    Route::post('/tareas/{id}/comentarios', [ComentarioController::class, 'store']);
});
