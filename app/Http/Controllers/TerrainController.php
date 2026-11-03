<?php

namespace App\Http\Controllers;

use App\Models\Terrain;
use App\Http\Requests\EnregistrerTerrainRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Throwable;

class TerrainController
{
    public function index(): View
    {
        $terrains = Terrain::query()->latest()->paginate(10);
        return view('terrains.index', compact('terrains'));
    }

    public function create(): View
    {
        return view('terrains.create');
    }

    public function store(EnregistrerTerrainRequest $request)
    {
        // 1. Récupérer les données validées et forcer le user_id du créateur
        $data = $request->safe()->except('image');
        $data['user_id'] = $request->user()->id; 
        
        // 2. Stocker l'image
        $path = $request->file('image')?->store('terrains', 'public');

        try {
            // 3. Créer le terrain une seule fois avec toutes les infos
            $terrain = Terrain::create([
                ...$data,
                'image_path' => $path,
            ]);
        } catch (Throwable $exception) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
            throw $exception;
        }

        return redirect()->route('terrains.show', $terrain)
            ->with('status', 'Terrain ajouté avec succès.');
    }

    public function show(Terrain $terrain): View
    {
        return view('terrains.show', compact('terrain'));
    }

    public function edit(Terrain $terrain): View
    {
        Gate::authorize('update', $terrain); // Sécurité : bloque si pas le propriétaire
        return view('terrains.edit', compact('terrain'));
    }

    public function update(EnregistrerTerrainRequest $request, Terrain $terrain)
    {
        Gate::authorize('update', $terrain); // Sécurité

        $data = $request->safe()->except('image');
        $newPath = $request->file('image')?->store('terrains', 'public');
        $oldPath = $terrain->image_path;

        try {
            $terrain->update([
                ...$data,
                ...($newPath ? ['image_path' => $newPath] : []),
            ]);
        } catch (Throwable $exception) {
            if ($newPath) {
                Storage::disk('public')->delete($newPath);
            }
            throw $exception;
        }

        if ($newPath && $oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return redirect()->route('terrains.show', $terrain)->with('status', 'Terrain modifié avec succès.');
    }

    public function destroy(Terrain $terrain): RedirectResponse
    {
        Gate::authorize('delete', $terrain); // Sécurité

        if ($terrain->image_path) {
            Storage::disk('public')->delete($terrain->image_path);
        }
        
        $terrain->delete();
        return redirect()->route('terrains.index')->with('status', 'Terrain supprimé.');
    }

    public function destroyImage(Terrain $terrain)
    {
        Gate::authorize('update', $terrain); // Sécurité

        if ($terrain->image_path) {
            Storage::disk('public')->delete($terrain->image_path); 
            $terrain->update(['image_path' => null]); 
        }
        return back()->with('status', 'Image supprimée.');
    }
}