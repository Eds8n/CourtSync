@extends('layouts.app')

@section('title', $terrain->nom)

@section('content')
    <h1>{{ $terrain->nom }}</h1>

    @if (session('status'))
        <p style="color:green;">{{ session('status') }}</p>
    @endif

    <p><strong>Type :</strong> {{ $terrain->type }}</p>
    <p><strong>Adresse :</strong> {{ $terrain->adresse }}</p>

    @if($terrain->image_path)
        <img src="{{ asset('storage/' . $terrain->image_path) }}" alt="Image de {{ $terrain->nom }}" style="max-width: 100%; height: auto;">
    @endif

    <div style="margin-top: 20px;">
        {{-- Ces boutons ne s'afficheront que pour le propriétaire du terrain --}}
        @can('update', $terrain)
            <a href="{{ route('terrains.edit', $terrain) }}" style="display:inline-block; margin-right:15px;">Modifier le terrain</a>
        @endcan

        @can('delete', $terrain)
            <form method="post" action="{{ route('terrains.destroy', $terrain) }}" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" style="color: red;">Supprimer le terrain</button>
            </form>
        @endcan
    </div>

    <p style="margin-top: 20px;"><a href="{{ route('terrains.index') }}">Retour à la liste</a></p>
@endsection