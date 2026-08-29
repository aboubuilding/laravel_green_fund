<?php

use App\Http\Controllers\ActualiteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommuniqueController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\FaciliteController;
use App\Http\Controllers\GriefController;
use App\Http\Controllers\GuichetController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\ManifestationController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PlainteController;
use App\Http\Controllers\PolitiqueController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\ProjetFinanceController;
use App\Http\Controllers\SoumissionController;
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


// Gestion des documents
Route::prefix('documents')->name('documents.')->middleware(['auth'])->group(function () {
    Route::get('/', [DocumentController::class, 'index'])->name('index');
    Route::get('/filter', [DocumentController::class, 'filter'])->name('filter');
    Route::get('/search', [DocumentController::class, 'search'])->name('search');
    Route::get('/{id}/edit', [DocumentController::class, 'edit'])->name('edit');
    Route::get('/{id}/download', [DocumentController::class, 'download'])->name('download');
    Route::post('/', [DocumentController::class, 'store'])->name('store');
    Route::put('/{id}', [DocumentController::class, 'update'])->name('update');
    Route::delete('/{id}', [DocumentController::class, 'destroy'])->name('destroy');
});


// Gestion des médias
Route::prefix('media')->name('media.')->middleware(['auth'])->group(function () {
    Route::get('/', [MediaController::class, 'index'])->name('index');
    Route::get('/filter', [MediaController::class, 'filter'])->name('filter');
    Route::get('/search', [MediaController::class, 'search'])->name('search');
    Route::get('/{id}/edit', [MediaController::class, 'edit'])->name('edit');
    Route::post('/', [MediaController::class, 'store'])->name('store');
    Route::put('/{id}', [MediaController::class, 'update'])->name('update');
    Route::delete('/{id}', [MediaController::class, 'destroy'])->name('destroy');
});

// Gestion des publications (politiques)
Route::prefix('politiques')->name('politiques.')->middleware(['auth'])->group(function () {
    Route::get('/', [PolitiqueController::class, 'index'])->name('index');
    Route::get('/filter', [PolitiqueController::class, 'filter'])->name('filter');
    Route::get('/search', [PolitiqueController::class, 'search'])->name('search');
    Route::get('/{id}/edit', [PolitiqueController::class, 'edit'])->name('edit');
    Route::get('/{id}/download', [PolitiqueController::class, 'download'])->name('download');
    Route::post('/', [PolitiqueController::class, 'store'])->name('store');
    Route::post('/{id}/publish', [PolitiqueController::class, 'publish'])->name('publish');
    Route::post('/{id}/unpublish', [PolitiqueController::class, 'unpublish'])->name('unpublish');
    Route::put('/{id}', [PolitiqueController::class, 'update'])->name('update');
    Route::delete('/{id}', [PolitiqueController::class, 'destroy'])->name('destroy');
});

// Gestion de la newsletter
Route::prefix('newsletter')->name('newsletter.')->middleware(['auth'])->group(function () {
    Route::get('/', [NewsletterController::class, 'index'])->name('index');
    Route::get('/filter', [NewsletterController::class, 'filter'])->name('filter');
    Route::get('/search', [NewsletterController::class, 'search'])->name('search');
    Route::get('/export', [NewsletterController::class, 'export'])->name('export');
    Route::get('/stats', [NewsletterController::class, 'stats'])->name('stats');
    Route::post('/', [NewsletterController::class, 'store'])->name('store');
    Route::post('/send', [NewsletterController::class, 'sendCampaign'])->name('send');
    Route::post('/{id}/unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('unsubscribe');
    Route::post('/{id}/resubscribe', [NewsletterController::class, 'resubscribe'])->name('resubscribe');
    Route::delete('/{id}', [NewsletterController::class, 'destroy'])->name('destroy');
});


// Gestion des actualités
Route::prefix('actualites')->name('actualites.')->middleware(['auth'])->group(function () {
    Route::get('/', [ActualiteController::class, 'index'])->name('index');
    Route::get('/filter', [ActualiteController::class, 'filter'])->name('filter');
    Route::get('/search', [ActualiteController::class, 'search'])->name('search');
    Route::get('/{id}/edit', [ActualiteController::class, 'edit'])->name('edit');
    Route::post('/', [ActualiteController::class, 'store'])->name('store');
    Route::post('/{id}/publish', [ActualiteController::class, 'publish'])->name('publish');
    Route::post('/{id}/unpublish', [ActualiteController::class, 'unpublish'])->name('unpublish');
    Route::put('/{id}', [ActualiteController::class, 'update'])->name('update');
    Route::delete('/{id}', [ActualiteController::class, 'destroy'])->name('destroy');
});

// Gestion des communiqués officiels
Route::prefix('communiques')->name('communiques.')->middleware(['auth'])->group(function () {
    Route::get('/', [CommuniqueController::class, 'index'])->name('index');
    Route::get('/filter', [CommuniqueController::class, 'filter'])->name('filter');
    Route::get('/search', [CommuniqueController::class, 'search'])->name('search');
    Route::get('/{id}/edit', [CommuniqueController::class, 'edit'])->name('edit');
    Route::get('/{id}/download', [CommuniqueController::class, 'download'])->name('download');
    Route::post('/', [CommuniqueController::class, 'store'])->name('store');
    Route::post('/{id}/publish', [CommuniqueController::class, 'publish'])->name('publish');
    Route::post('/{id}/unpublish', [CommuniqueController::class, 'unpublish'])->name('unpublish');
    Route::put('/{id}', [CommuniqueController::class, 'update'])->name('update');
    Route::delete('/{id}', [CommuniqueController::class, 'destroy'])->name('destroy');
});

// Gestion des événements
Route::prefix('evenements')->name('evenements.')->middleware(['auth'])->group(function () {
    Route::get('/', [EvenementController::class, 'index'])->name('index');
    Route::get('/filter', [EvenementController::class, 'filter'])->name('filter');
    Route::get('/search', [EvenementController::class, 'search'])->name('search');
    Route::get('/{id}/edit', [EvenementController::class, 'edit'])->name('edit');
    Route::post('/', [EvenementController::class, 'store'])->name('store');
    Route::post('/{id}/publish', [EvenementController::class, 'publish'])->name('publish');
    Route::post('/{id}/unpublish', [EvenementController::class, 'unpublish'])->name('unpublish');
    Route::put('/{id}', [EvenementController::class, 'update'])->name('update');
    Route::delete('/{id}', [EvenementController::class, 'destroy'])->name('destroy');
});


// Gestion des infos
Route::prefix('infos')->name('infos.')->middleware(['auth'])->group(function () {
    Route::get('/', [InfoController::class, 'index'])->name('index');
    Route::get('/filter', [InfoController::class, 'filter'])->name('filter');
    Route::get('/search', [InfoController::class, 'search'])->name('search');
    Route::get('/{id}/edit', [InfoController::class, 'edit'])->name('edit');
    Route::post('/', [InfoController::class, 'store'])->name('store');
    Route::post('/{id}/toggle-status', [InfoController::class, 'toggleStatus'])->name('toggle-status');
    Route::put('/{id}', [InfoController::class, 'update'])->name('update');
    Route::delete('/{id}', [InfoController::class, 'destroy'])->name('destroy');
});


// Gestion des guichets
Route::prefix('guichets')->name('guichets.')->middleware(['auth'])->group(function () {
    Route::get('/', [GuichetController::class, 'index'])->name('index');
    Route::get('/filter', [GuichetController::class, 'filter'])->name('filter');
    Route::get('/search', [GuichetController::class, 'search'])->name('search');
    Route::get('/{id}/edit', [GuichetController::class, 'edit'])->name('edit');
    Route::get('/{id}', [GuichetController::class, 'show'])->name('show');
    Route::post('/', [GuichetController::class, 'store'])->name('store');
    Route::put('/{id}', [GuichetController::class, 'update'])->name('update');
    Route::delete('/{id}', [GuichetController::class, 'destroy'])->name('destroy');

    // Chiffres clés
    Route::post('/{id}/chiffres', [GuichetController::class, 'addChiffre'])->name('add-chiffre');
    Route::put('/chiffres/{id}', [GuichetController::class, 'updateChiffre'])->name('update-chiffre');
    Route::delete('/chiffres/{id}', [GuichetController::class, 'deleteChiffre'])->name('delete-chiffre');

    // Projets associés
    Route::post('/{guichetId}/attach/{projetId}', [GuichetController::class, 'attachProject'])->name('attach-project');
    Route::post('/{guichetId}/detach/{projetId}', [GuichetController::class, 'detachProject'])->name('detach-project');
});

// Gestion des facilités
Route::prefix('facilites')->name('facilites.')->middleware(['auth'])->group(function () {
    Route::get('/', [FaciliteController::class, 'index'])->name('index');
    Route::get('/filter', [FaciliteController::class, 'filter'])->name('filter');
    Route::get('/search', [FaciliteController::class, 'search'])->name('search');
    Route::get('/{id}/edit', [FaciliteController::class, 'edit'])->name('edit');
    Route::get('/{id}', [FaciliteController::class, 'show'])->name('show');
    Route::post('/', [FaciliteController::class, 'store'])->name('store');
    Route::put('/{id}', [FaciliteController::class, 'update'])->name('update');
    Route::delete('/{id}', [FaciliteController::class, 'destroy'])->name('destroy');

    // Chiffres clés
    Route::post('/{id}/chiffres', [FaciliteController::class, 'addChiffre'])->name('add-chiffre');
    Route::put('/chiffres/{id}', [FaciliteController::class, 'updateChiffre'])->name('update-chiffre');
    Route::delete('/chiffres/{id}', [FaciliteController::class, 'deleteChiffre'])->name('delete-chiffre');

    // Projets associés
    Route::post('/{faciliteId}/attach/{projetId}', [FaciliteController::class, 'attachProject'])->name('attach-project');
    Route::post('/{faciliteId}/detach/{projetId}', [FaciliteController::class, 'detachProject'])->name('detach-project');
});


// Gestion des griefs
Route::prefix('griefs')->name('griefs.')->middleware(['auth'])->group(function () {
    Route::get('/', [GriefController::class, 'index'])->name('index');
    Route::get('/filter', [GriefController::class, 'filter'])->name('filter');
    Route::get('/search', [GriefController::class, 'search'])->name('search');
    Route::get('/export', [GriefController::class, 'export'])->name('export');
    Route::get('/{id}/edit', [GriefController::class, 'edit'])->name('edit');
    Route::get('/{id}', [GriefController::class, 'show'])->name('show');
    Route::post('/', [GriefController::class, 'store'])->name('store');
    Route::post('/{id}/changer-statut', [GriefController::class, 'changerStatut'])->name('changer-statut');
    Route::post('/{id}/repondre', [GriefController::class, 'repondre'])->name('repondre');
    Route::post('/{id}/cloturer', [GriefController::class, 'cloturer'])->name('cloturer');
    Route::put('/{id}', [GriefController::class, 'update'])->name('update');
    Route::delete('/{id}', [GriefController::class, 'destroy'])->name('destroy');
});

// Gestion des plaintes
Route::prefix('plaintes')->name('plaintes.')->middleware(['auth'])->group(function () {
    Route::get('/', [PlainteController::class, 'index'])->name('index');
    Route::get('/filter', [PlainteController::class, 'filter'])->name('filter');
    Route::get('/search', [PlainteController::class, 'search'])->name('search');
    Route::get('/export', [PlainteController::class, 'export'])->name('export');
    Route::get('/{id}/edit', [PlainteController::class, 'edit'])->name('edit');
    Route::get('/{id}', [PlainteController::class, 'show'])->name('show');
    Route::post('/', [PlainteController::class, 'store'])->name('store');
    Route::post('/{id}/changer-statut', [PlainteController::class, 'changerStatut'])->name('changer-statut');
    Route::post('/{id}/repondre', [PlainteController::class, 'repondre'])->name('repondre');
    Route::post('/{id}/cloturer', [PlainteController::class, 'cloturer'])->name('cloturer');
    Route::put('/{id}', [PlainteController::class, 'update'])->name('update');
    Route::delete('/{id}', [PlainteController::class, 'destroy'])->name('destroy');
});


// Gestion des projets
Route::prefix('projets')->name('projets.')->middleware(['auth'])->group(function () {
    Route::get('/', [ProjetController::class, 'index'])->name('index');
    Route::get('/filter', [ProjetController::class, 'filter'])->name('filter');
    Route::get('/search', [ProjetController::class, 'search'])->name('search');
    Route::get('/{id}/edit', [ProjetController::class, 'edit'])->name('edit');
    Route::get('/{id}', [ProjetController::class, 'show'])->name('show');
    Route::post('/', [ProjetController::class, 'store'])->name('store');
    Route::put('/{id}', [ProjetController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProjetController::class, 'destroy'])->name('destroy');
});

// Gestion des manifestations d'intérêt
Route::prefix('manifestations')->name('manifestations.')->middleware(['auth'])->group(function () {
    Route::get('/', [ManifestationController::class, 'index'])->name('index');
    Route::get('/filter', [ManifestationController::class, 'filter'])->name('filter');
    Route::get('/search', [ManifestationController::class, 'search'])->name('search');
    Route::get('/export', [ManifestationController::class, 'export'])->name('export');
    Route::get('/{id}/edit', [ManifestationController::class, 'edit'])->name('edit');
    Route::get('/{id}', [ManifestationController::class, 'show'])->name('show');
    Route::post('/', [ManifestationController::class, 'store'])->name('store');
    Route::post('/{id}/traiter', [ManifestationController::class, 'traiter'])->name('traiter');
    Route::post('/{id}/email', [ManifestationController::class, 'envoyerEmail'])->name('email');
    Route::put('/{id}', [ManifestationController::class, 'update'])->name('update');
    Route::delete('/{id}', [ManifestationController::class, 'destroy'])->name('destroy');
});


// Gestion des soumissions
Route::prefix('soumissions')->name('soumissions.')->middleware(['auth'])->group(function () {
    Route::get('/', [SoumissionController::class, 'index'])->name('index');
    Route::get('/filter', [SoumissionController::class, 'filter'])->name('filter');
    Route::get('/search', [SoumissionController::class, 'search'])->name('search');
    Route::get('/{id}/edit', [SoumissionController::class, 'edit'])->name('edit');
    Route::get('/{id}', [SoumissionController::class, 'show'])->name('show');
    Route::get('/{id}/historiques', [SoumissionController::class, 'getHistoriques'])->name('historiques');
    Route::get('/{id}/messages-public', [SoumissionController::class, 'getMessagesPublic'])->name('messages-public');
    Route::post('/', [SoumissionController::class, 'store'])->name('store');
    Route::post('/{id}/changer-statut', [SoumissionController::class, 'changerStatut'])->name('changer-statut');
    Route::put('/{id}', [SoumissionController::class, 'update'])->name('update');
    Route::delete('/{id}', [SoumissionController::class, 'destroy'])->name('destroy');
});

// Gestion des projets financés
Route::prefix('projet-finances')->name('projet-finances.')->middleware(['auth'])->group(function () {
    Route::get('/', [ProjetFinanceController::class, 'index'])->name('index');
    Route::get('/filter', [ProjetFinanceController::class, 'filter'])->name('filter');
    Route::get('/search', [ProjetFinanceController::class, 'search'])->name('search');
    Route::get('/{id}/edit', [ProjetFinanceController::class, 'edit'])->name('edit');
    Route::get('/{id}', [ProjetFinanceController::class, 'show'])->name('show');
    Route::post('/', [ProjetFinanceController::class, 'store'])->name('store');
    Route::post('/{id}/toggle-mise-en-avant', [ProjetFinanceController::class, 'toggleMiseEnAvant'])->name('toggle-mise-en-avant');
    Route::put('/{id}', [ProjetFinanceController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProjetFinanceController::class, 'destroy'])->name('destroy');
});

// ============================================
// REDIRECTION PAR DÉFAUT
// ============================================

Route::get('/', function () {
    return redirect()->route('login');
});
