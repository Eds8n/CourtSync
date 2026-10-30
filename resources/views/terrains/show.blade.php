@extends('layouts.app')

@section('content')
<h1>{{ $terrain->nom }}</h1>

@if (session('status'))
    <p style="color:green;">{{ session('status') }}</p>
@endif

<p><strong>Adresse :</strong> {{ $terrain->adresse }}</p>
<p><strong>Type :</strong> {{ $terrain->type }}</p>
@if ($terrain->image_path)
    <div style="margin: 20px 0;">
        <img src="{{ Storage::disk('public')->url($terrain->image_path) }}" 
             alt="Photo de {{ $terrain->nom }}" 
             style="max-width: 300px; height: auto;">
    </div>
@endif

<p><a href="{{ route('terrains.edit', $terrain) }}">Modifier ce terrain</a></p>

<form method="post" action="{{ route('terrains.destroy', $terrain) }}">
    @csrf
    @method('DELETE')
    <button type="submit" style="color:red;">Supprimer ce terrain</button>
</form>

<p><a href="{{ route('terrains.index') }}">Retour à la liste</a></p>
@endsection