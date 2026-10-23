<h1>Liste des Terrains</h1>

@if (session('status'))
    <p style="color:green;">{{ session('status') }}</p>
@endif

<p><a href="{{ route('terrains.create') }}">Ajouter un nouveau terrain</a></p>

@forelse ($terrains as $terrain)
    <article>
        <h2><a href="{{ route('terrains.show', $terrain) }}">{{ $terrain->nom }}</a></h2>
        <p>{{ $terrain->type }} - {{ $terrain->adresse }}</p>
    </article>
@empty
    <p>Aucun terrain disponible pour le moment.</p>
@endforelse

{{ $terrains->links() }}