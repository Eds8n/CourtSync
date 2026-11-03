@extends('layouts.app')

@section('title', 'Inscription - CourtSync')

@section('content')
    <h1>Créer un compte</h1>

    <form method="post" action="{{ route('register.store') }}" style="max-width: 500px; margin: 0 auto;">
        @csrf

        <div>
            <label for="name">Nom</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required>
            @error('name') <p style="color: var(--accent-red); margin-top: 5px;">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email">Adresse courriel</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required>
            @error('email') <p style="color: var(--accent-red); margin-top: 5px;">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email_confirmation">Confirmer l'adresse courriel</label>
            <input id="email_confirmation" name="email_confirmation" type="email" value="{{ old('email_confirmation') }}" required>
        </div>

        <div>
            <label for="password">Mot de passe</label>
            <input id="password" name="password" type="password" required>
            @error('password') <p style="color: var(--accent-red); margin-top: 5px;">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirmation du mot de passe</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required>
        </div>

        <!-- Widget reCAPTCHA -->
        <div style="margin: 20px 0;">
            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
            @error('g-recaptcha-response') <p style="color: var(--accent-red); margin-top: 5px;">{{ $message }}</p> @enderror
        </div>

        <button type="submit" style="width: 100%;">Créer le compte</button>
    </form>
@endsection

@push('scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush