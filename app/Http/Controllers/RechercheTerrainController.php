<?php

namespace App\Http\Controllers;

use App\Models\Terrain;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RechercheTerrainController
{
    public function __invoke(Request $request): JsonResponse
    {
        // 1. Validation : le terme tapé doit faire entre 2 et 50 caractères
        $data = $request->validate([
            'q' => ['required', 'string', 'min:2', 'max:50'],
        ]);

        // 2. Requête Eloquent : Chercher dans le nom OU dans l'adresse, limité à 8 résultats
        $terrains = Terrain::query()
            ->where('nom', 'like', '%' . $data['q'] . '%')
            ->orWhere('adresse', 'like', '%' . $data['q'] . '%')
            ->orderBy('nom')
            ->limit(8)
            ->get(['id', 'nom', 'adresse']);

        // 3. Retourner les données en format JSON pour le JavaScript
        return response()->json([
            'data' => $terrains->map(fn (Terrain $terrain) => [
                'id' => $terrain->id,
                'label' => $terrain->nom . ' (' . $terrain->adresse . ')',
                'url' => route('terrains.show', $terrain),
            ]),
        ]);
    }
}