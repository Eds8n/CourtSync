@extends('layouts.app')

@section('title', 'Mon Compte')

@section('content')
    <h1>Mon compte : {{ $user->name }}</h1>
    <p style="color: var(--text-muted);">Rôle : {{ ucfirst($user->role) }}</p>

    <h2>Mes Terrains ajoutés</h2>
    <div class="terrains-grid">
        @forelse ($terrains as $terrain)
            <article>
                <h3><a href="{{ route('terrains.show', $terrain) }}">{{ $terrain->nom }}</a></h3>
                <p>{{ $terrain->type }} - {{ $terrain->adresse }}</p>
            </article>
        @empty
            <p>Vous n'avez créé aucun terrain pour le moment.</p>
        @endforelse
    </div>
@endsection