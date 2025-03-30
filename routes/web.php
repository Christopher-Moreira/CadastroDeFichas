<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonagemController; // Adicionei o controller faltante

// Rotas públicas (acesso sem autenticação)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Rotas protegidas (acesso apenas com autenticação)
Route::middleware('auth')->group(function () {
    Route::get('/pagina_principal', [AuthController::class, 'paginaPrincipal'])->name('pagina.principal');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Rotas de Personagem
    Route::get('/personagens/create', [PersonagemController::class, 'create'])->name('personagens.create');
    Route::post('/personagens', [PersonagemController::class, 'store'])->name('personagens.store');
});