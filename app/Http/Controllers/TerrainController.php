<?php

namespace App\Http\Controllers;

use App\Models\Terrain;
use App\Http\Requests\EnregistrerTerrainRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

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

    public function store(EnregistrerTerrainRequest $request): RedirectResponse
    {
        $terrain = Terrain::create($request->validated());
        return redirect()->route('terrains.show', $terrain)->with('status', 'Terrain ajouté avec succès.');
    }

    public function show(Terrain $terrain): View
    {
        return view('terrains.show', compact('terrain'));
    }

    public function edit(Terrain $terrain): View
    {
        return view('terrains.edit', compact('terrain'));
    }

    public function update(EnregistrerTerrainRequest $request, Terrain $terrain): RedirectResponse
    {
        $terrain->update($request->validated());
        return redirect()->route('terrains.show', $terrain)->with('status', 'Terrain modifié avec succès.');
    }

    public function destroy(Terrain $terrain): RedirectResponse
    {
        $terrain->delete();
        return redirect()->route('terrains.index')->with('status', 'Terrain supprimé.');
    }
}