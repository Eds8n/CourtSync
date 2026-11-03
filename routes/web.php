<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use App\Http\Controllers\TerrainController;
use App\Http\Controllers\RechercheTerrainController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompteController;
use App\Http\Middleware\EnsureAdmin;

// 1. Route pour la langue
Route::post('/langue', function (Illuminate\Http\Request $request) {
    $data = $request->validate([
        'locale' => ['required', Rule::in(['fr', 'en'])],
    ]);

    $request->session()->put('locale', $data['locale']);

    return back();
})->name('locale.update');

// 2. Routes pour les terrains

// recherche publique
Route::get('/recherche/terrains', RechercheTerrainController::class)
    ->name('recherche.terrains');

// gestion reservee aux admins
Route::middleware(['auth', EnsureAdmin::class])->group(function () {
    Route::resource('terrains', TerrainController::class)
        ->except(['index', 'show']);

    Route::delete('/terrains/{terrain}/image', [
        TerrainController::class,
        'destroyImage'
    ])->name('terrains.image.destroy');

    Route::get('/administration', function () {
        return 'Bienvenue dans la zone d\'administration (Réservé aux admins) !';
    })->name('admin.index');
});

// consultation publique
Route::resource('terrains', TerrainController::class)
    ->only(['index', 'show']);

// 3. Pages statiques
Route::get('/', function () {
    return view('welcome');
});

Route::view('/recits', 'recits')->name('recits');

// 4. Inscription
Route::get('/inscription', [InscriptionController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/inscription', [InscriptionController::class, 'store'])
    ->middleware('guest')
    ->name('register.store');

// 5. Connexion et deconnexion
Route::get('/connexion', [AuthController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/connexion', [AuthController::class, 'login'])
    ->middleware(['guest', 'throttle:6,1'])
    ->name('login.store');

Route::post('/deconnexion', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// 6. Mon compte
Route::get('/compte', [CompteController::class, 'show'])
    ->middleware('auth')
    ->name('account.show');