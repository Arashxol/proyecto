<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistroController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\TipoAnalisisController;
use App\Http\Controllers\OrdenAnalisisController;
use App\Http\Controllers\MuestraController;
use App\Http\Controllers\ResultadoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

// Ruta pública de inicio
Route::get('/', function () {
    return view('inicio');
})->name('inicio');

// Rutas de autenticación
Route::get('/login', [LoginController::class, 'mostrarFormularioLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/registro', [RegistroController::class, 'mostrarFormularioRegistro'])->name('registro');
Route::post('/registro', [RegistroController::class, 'registrar']);

// Rutas protegidas (requieren autenticación)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ==================== PACIENTES ====================
    Route::prefix('pacientes')->group(function () {
        Route::get('/', [PacienteController::class, 'index'])->name('pacientes.index');
        Route::get('/crear', [PacienteController::class, 'create'])->name('pacientes.create');
        Route::post('/', [PacienteController::class, 'store'])->name('pacientes.store');
        Route::get('/{paciente}', [PacienteController::class, 'show'])->name('pacientes.show');
        Route::get('/{paciente}/editar', [PacienteController::class, 'edit'])->name('pacientes.edit');
        Route::put('/{paciente}', [PacienteController::class, 'update'])->name('pacientes.update');
        Route::delete('/{paciente}', [PacienteController::class, 'destroy'])->name('pacientes.destroy');
    });

    // ==================== TIPOS DE ANÁLISIS ====================
    Route::prefix('tipos-analisis')->group(function () {
        Route::get('/', [TipoAnalisisController::class, 'index'])->name('tipos-analisis.index');
        Route::get('/crear', [TipoAnalisisController::class, 'create'])->name('tipos-analisis.create');
        Route::post('/', [TipoAnalisisController::class, 'store'])->name('tipos-analisis.store');
        Route::get('/{tiposAnalisis}', [TipoAnalisisController::class, 'show'])->name('tipos-analisis.show');
        Route::get('/{tiposAnalisis}/editar', [TipoAnalisisController::class, 'edit'])->name('tipos-analisis.edit');
        Route::put('/{tiposAnalisis}', [TipoAnalisisController::class, 'update'])->name('tipos-analisis.update');
        Route::delete('/{tiposAnalisis}', [TipoAnalisisController::class, 'destroy'])->name('tipos-analisis.destroy');
    });

    // ==================== ÓRDENES DE ANÁLISIS ====================
    Route::prefix('ordenes-analisis')->group(function () {
        Route::get('/', [OrdenAnalisisController::class, 'index'])->name('ordenes-analisis.index');
        Route::get('/crear', [OrdenAnalisisController::class, 'create'])->name('ordenes-analisis.create');
        Route::post('/', [OrdenAnalisisController::class, 'store'])->name('ordenes-analisis.store');
        Route::get('/{ordenesAnalisis}', [OrdenAnalisisController::class, 'show'])->name('ordenes-analisis.show');
        Route::get('/{ordenesAnalisis}/editar', [OrdenAnalisisController::class, 'edit'])->name('ordenes-analisis.edit');
        Route::put('/{ordenesAnalisis}', [OrdenAnalisisController::class, 'update'])->name('ordenes-analisis.update');
        Route::delete('/{ordenesAnalisis}', [OrdenAnalisisController::class, 'destroy'])->name('ordenes-analisis.destroy');
        
        // Rutas adicionales para órdenes
        Route::post('/{orden}/cambiar-estado', [OrdenAnalisisController::class, 'cambiarEstado'])->name('ordenes-analisis.cambiar-estado');
    });

    // ==================== MUESTRAS ====================
    Route::prefix('muestras')->group(function () {
        Route::get('/', [MuestraController::class, 'index'])->name('muestras.index');
        Route::get('/{muestra}', [MuestraController::class, 'show'])->name('muestras.show');
        Route::get('/{muestra}/editar', [MuestraController::class, 'edit'])->name('muestras.edit');
        Route::put('/{muestra}', [MuestraController::class, 'update'])->name('muestras.update');
        Route::delete('/{muestra}', [MuestraController::class, 'destroy'])->name('muestras.destroy');
        
        // Rutas adicionales para muestras
        Route::get('/pendientes', [MuestraController::class, 'pendientes'])->name('muestras.pendientes');
        Route::post('/{muestra}/asignar-tecnico', [MuestraController::class, 'asignarTecnico'])->name('muestras.asignar-tecnico');
    });

    });