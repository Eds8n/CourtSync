<h1>Ajouter un terrain</h1>
<form method="post" action="{{ route('terrains.store') }}">
    @include('terrains._form', ['terrain' => null])
</form>
<p><a href="{{ route('terrains.index') }}">Annuler</a></p>