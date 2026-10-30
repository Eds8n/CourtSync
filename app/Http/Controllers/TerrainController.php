<?php

namespace App\Http\Controllers;

use App\Models\Terrain;
use App\Http\Requests\EnregistrerTerrainRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
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
    // 1. Récupérer les données validées sans l'image
    $data = $request->safe()->except('image');
    
    // 2. Stocker l'image (Laravel la renomme automatiquement et la met dans 'terrains')
    $path = $request->file('image')?->store('terrains', 'public');

    try {
        // 3. Créer le terrain dans la base de données avec le chemin de l'image
        $terrain = Terrain::create([
            ...$data,
            'image_path' => $path,
        ]);
    } catch (Throwable $exception) {
        // 4. Si la base de données plante, on supprime l'image du disque pour ne pas polluer
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
        return view('terrains.edit', compact('terrain'));
    }

    public function update(EnregistrerTerrainRequest $request, Terrain $terrain)
{
    $data = $request->safe()->except('image');
    $newPath = $request->file('image')?->store('terrains', 'public');
    $oldPath = $terrain->image_path; // On mémorise l'ancien chemin

    try {
        $terrain->update([
            ...$data,
            ...($newPath ? ['image_path' => $newPath] : []), // On met à jour seulement si une nouvelle image est fournie
        ]);
    } catch (Throwable $exception) {
        if ($newPath) {
            Storage::disk('public')->delete($newPath);
        }
        throw $exception;
    }

    // Si tout s'est bien passé et qu'on a remplacé une image, on détruit l'ancienne
    if ($newPath && $oldPath) {
        Storage::disk('public')->delete($oldPath);
    }

    return redirect()->route('terrains.show', $terrain)->with('status', 'Terrain modifié avec succès.');
}

   public function destroy(Terrain $terrain): RedirectResponse
    {
        // On supprime l'image du disque dur si elle existe
        if ($terrain->image_path) {
            Storage::disk('public')->delete($terrain->image_path);
        }
        
        $terrain->delete(); // Ensuite on supprime le terrain de la BD
        return redirect()->route('terrains.index')->with('status', 'Terrain supprimé.');
    }

    public function destroyImage(Terrain $terrain)
{
    if ($terrain->image_path) {
        Storage::disk('public')->delete($terrain->image_path); // Efface le fichier
        $terrain->update(['image_path' => null]); // Vide la base de données
    }
    return back()->with('status', 'Image supprimée.');
}
}