@csrf
<div>
    <label for="nom">Nom du terrain</label>
    <input id="nom" name="nom" value="{{ old('nom', $terrain?->nom) }}">
    @error('nom') <p style="color:red;">{{ $message }}</p> @enderror
</div>
<div>
    <label for="adresse">Adresse</label>
    <input id="adresse" name="adresse" value="{{ old('adresse', $terrain?->adresse) }}">
    @error('adresse') <p style="color:red;">{{ $message }}</p> @enderror
</div>
<div>
    <label for="type">Type (Intérieur/Extérieur)</label>
    <input id="type" name="type" value="{{ old('type', $terrain?->type) }}">
    @error('type') <p style="color:red;">{{ $message }}</p> @enderror
</div>
<div>
    <label for="image">Photo du terrain (optionnelle)</label>
    <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp">
    @error('image') 
        <p style="color: red;">{{ $message }}</p> 
    @enderror
</div>
<button type="submit">Enregistrer le terrain</button>