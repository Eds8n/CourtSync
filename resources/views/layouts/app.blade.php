<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'CourtSync')</title>
    <!-- Le futur fichier CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<header style="display: flex; justify-content: space-between; align-items: center;">
    <nav style="display: flex; gap: 20px;">
        <a href="{{ url('/') }}">Accueil</a>
        <a href="{{ route('terrains.index') }}">Terrains</a>
        <a href="{{ url('/recits') }}">Récits</a>
    </nav>
    
    <form method="post" action="{{ route('locale.update') }}" style="margin: 0; padding: 0; background: transparent; border: none;">
        @csrf
        <label for="locale" style="display:inline; margin-right: 5px;">Langue :</label>
        <select id="locale" name="locale" onchange="this.form.submit()" style="width: auto; padding: 5px;">
            <option value="fr" @selected(app()->getLocale() === 'fr')>FR</option>
            <option value="en" @selected(app()->getLocale() === 'en')>EN</option>
        </select>
    </form>
</header>

    <main>
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>