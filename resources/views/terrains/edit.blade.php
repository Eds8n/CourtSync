@extends('layouts.app')

@section('content')
<h1>Modifier le terrain {{ $terrain->nom }}</h1>

{{-- 1. Le bloc de l'image actuelle avec son propre bouton poubelle --}}
@if ($terrain->image_path)
    <div style="margin: 20px 0; padding: 10px; border: 1px solid #ccc;">
        <p>Image actuelle :</p>
        <img src="{{ Storage::disk('public')->url($terrain->image_path) }}" alt="Photo de {{ $terrain->nom }}" style="max-width: 150px;">
        
        <form method="post" action="{{ route('terrains.image.destroy', $terrain) }}" style="margin-top: 10px;">
            @csrf
            @method('DELETE')
            <button type="submit" style="color: red; border-color: red;">🗑️ Supprimer uniquement l'image</button>
        </form>
    </div>
@endif

{{-- 2. Le formulaire principal de modification --}}
<form method="post" action="{{ route('terrains.update', $terrain) }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div>
        <label for="nom">Nom</label>
        <input id="nom" name="nom" type="text" value="{{ old('nom', $terrain->nom) }}">
    </div>
    
    <div>
        <label for="adresse">Adresse</label>
        <input id="adresse" name="adresse" type="text" value="{{ old('adresse', $terrain->adresse) }}">
    </div>

    <div>
        <label for="type">Type</label>
        <select id="type" name="type">
            <option value="Interieur" @selected(old('type', $terrain->type) === 'Interieur')>Intérieur</option>
            <option value="Exterieur" @selected(old('type', $terrain->type) === 'Exterieur')>Extérieur</option>
        </select>
    </div>

    <div>
        <label for="image">Ajouter ou remplacer la photo</label>
        <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp">
        @error('image') 
            <p style="color: red;">{{ $message }}</p> 
        @enderror
    </div>

    <br>
    <button type="submit">Enregistrer les modifications</button>
</form>

<br>
<a href="{{ route('terrains.show', $terrain) }}">Annuler</a>
@endsection