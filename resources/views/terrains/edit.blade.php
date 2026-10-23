<h1>Modifier le terrain : {{ $terrain->nom }}</h1>
<form method="post" action="{{ route('terrains.update', $terrain) }}">
    @method('PATCH')
    @include('terrains._form')
</form>
<p><a href="{{ route('terrains.show', $terrain) }}">Annuler</a></p>