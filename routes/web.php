<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ============================================
// ROUTES PUBLIQUES (sans authentification)
// ============================================


    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');


Route::get('/check-session', [AuthController::class, 'checkSession'])->name('check.session');

// ============================================
// ROUTES PROTÉGÉES (authentification requise)
// ============================================



    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/dashboard/stats', [DashboardController::class, 'stats'])->name('api.dashboard.stats');
    // Déconnexion (POST uniquement)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Gestion des utilisateurs (API + Vue)
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::put('/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
});


// ============================================
// REDIRECTION PAR DÉFAUT
// ============================================

Route::get('/', function () {
    return redirect()->route('login');
});
