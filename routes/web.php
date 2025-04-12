<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonagemController;
use App\Http\Controllers\RoomController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rotas de autenticação
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rota para seleção de papel
Route::get('/escolha-papel', [AuthController::class, 'showRoleSelectionForm'])->name('role.selection');
Route::post('/escolha-papel', [AuthController::class, 'selectRole'])->name('role.select');

// Rotas protegidas por autenticação
Route::middleware(['auth'])->group(function () {
    // Rota para a página principal (Aventureiro)
    Route::get('/pagina-principal', [AuthController::class, 'paginaPrincipal'])->name('pagina.principal');
    
    // Rotas para admin (Guardião)
    Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
    
    // Rotas para gerenciamento de personagens
    Route::resource('personagens', PersonagemController::class);

    Route::get('/admin/pagina-admin', function () {
        return view('Pagina_admin');
    })->name('admin.dashboard');

    
    Route::prefix('salas')->group(function () {
        Route::get('/criar', [RoomController::class, 'create'])->name('salas.sala_create');
        Route::post('/criar', [RoomController::class, 'store'])->name('rooms.store');
        Route::get('/entrar', [RoomController::class, 'join'])->name('salas.sala_join');
        Route::post('/entrar', [RoomController::class, 'enter'])->name('rooms.enter');
        Route::get('/{code}', [RoomController::class, 'show'])->name('rooms.show');
    });
});
// Redirecionamento da raiz para login
Route::get('/', function () {
    return redirect()->route('login');
});