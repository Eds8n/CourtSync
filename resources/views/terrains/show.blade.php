<h1>{{ $terrain->nom }}</h1>

@if (session('status'))
    <p style="color:green;">{{ session('status') }}</p>
@endif

<p><strong>Adresse :</strong> {{ $terrain->adresse }}</p>
<p><strong>Type :</strong> {{ $terrain->type }}</p>

<p><a href="{{ route('terrains.edit', $terrain) }}">Modifier ce terrain</a></p>

<form method="post" action="{{ route('terrains.destroy', $terrain) }}">
    @csrf
    @method('DELETE')
    <button type="submit" style="color:red;">Supprimer ce terrain</button>
</form>

<p><a href="{{ route('terrains.index') }}">Retour à la liste</a></p>