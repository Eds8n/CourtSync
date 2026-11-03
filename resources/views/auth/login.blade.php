@extends('layouts.app')

@section('title', 'Connexion - CourtSync')

@section('content')
    <h1>Connexion</h1>

    <form method="post" action="{{ route('login.store') }}" style="max-width: 500px; margin: 0 auto;">
        @csrf
        
        <div>
            <label for="email">Adresse courriel</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required>
            @error('email') <p style="color: var(--accent-red); margin-top: 5px;">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password">Mot de passe</label>
            <input id="password" name="password" type="password" required>
        </div>

        <button type="submit" style="width: 100%;">Se connecter</button>
    </form>
@endsection