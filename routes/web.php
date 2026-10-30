<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TerrainController;
use App\Http\Controllers\RechercheTerrainController;
use Illuminate\Validation\Rule; // Importation requise pour le changement de langue

// 1. Route pour la langue
Route::post('/langue', function (Illuminate\Http\Request $request) {
    $data = $request->validate([
        'locale' => ['required', Rule::in(['fr', 'en'])],
    ]);
    $request->session()->put('locale', $data['locale']);
    return back();
})->name('locale.update');

// 2. Routes pour les terrains (recherche, image, et CRUD)
Route::get('/recherche/terrains', RechercheTerrainController::class)->name('recherche.terrains');
Route::delete('/terrains/{terrain}/image', [TerrainController::class, 'destroyImage'])->name('terrains.image.destroy');
Route::resource('terrains', TerrainController::class);

// 3. Routes pour les pages statiques (Accueil et Récits)
Route::get('/', function () {
    return view('welcome');
});

Route::view('/recits', 'recits')->name('recits'); 