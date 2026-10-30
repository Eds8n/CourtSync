@extends('layouts.app')

@section('title', 'Accueil - CourtSync')

@section('content')
    <div style="text-align: center; margin-top: 50px;">
        <h1 style="color: var(--accent-red); font-size: 3em;">Bienvenue sur CourtSync</h1>
        <p style="font-size: 1.2em; max-width: 600px; margin: 0 auto; color: var(--text-muted);">
            CourtSync est une application conçue pour t'aider à trouver rapidement des terrains 
            et des partenaires pour jouer au basketball, soccer ou autres sports. 
            Rejoins la communauté et planifie ton prochain match !
        </p>
        <br>
        <a href="{{ route('terrains.index') }}" style="display: inline-block; padding: 10px 20px; background-color: var(--accent-red); color: white; border-radius: 2px;">Voir les terrains</a>
    </div>
@endsection