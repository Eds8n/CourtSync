@extends('layouts.app')

@section('title', 'Ajouter un terrain')

@section('content')
    <h1>AJOUTER UN TERRAIN</h1>

    <div style="background-color: var(--surface-color); padding: 1.5rem; border: 1px solid var(--border-color); border-radius: 2px;">
        <form method="post" action="{{ route('terrains.store') }}" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom: 15px;">
                <label for="nom">Nom du terrain</label><br>
                <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required style="width: 100%;">
                @error('nom') <p style="color: var(--accent-red);">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label for="adresse">Adresse</label><br>
                <input type="text" name="adresse" id="adresse" value="{{ old('adresse') }}" required style="width: 100%;">
                @error('adresse') <p style="color: var(--accent-red);">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label for="type">Type</label><br>
                <select name="type" id="type" required style="width: 100%;">
                    <option value="Interieur">Intérieur</option>
                    <option value="Exterieur">Extérieur</option>
                </select>
                @error('type') <p style="color: var(--accent-red);">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label for="image">Image du terrain (optionnel)</label><br>
                <input type="file" name="image" id="image" accept="image/*">
                @error('image') <p style="color: var(--accent-red);">{{ $message }}</p> @enderror
            </div>

            <button type="submit" style="margin-right: 15px;">Ajouter</button>
            <a href="{{ route('terrains.index') }}" style="color: var(--accent-red);">Annuler</a>
        </form>
    </div>
@endsection