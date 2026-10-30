@extends('layouts.app')

@section('title', 'Liste des terrains')

@section('content')
    <h1>{{ __('interface.title') }}</h1>

    @if (session('status'))
        <p style="color:green;">{{ session('status') }}</p>
    @endif

    <p><a href="{{ route('terrains.create') }}">{{ __('interface.add') }}</a></p>
    
    <div style="margin-bottom: 20px;">
        <label for="search">{{ __('interface.search') }}</label><br>
        <input id="search" type="search" autocomplete="off"
               data-search-url="{{ route('recherche.terrains') }}"
               data-searching="{{ __('interface.searching') }}"
               data-empty="{{ __('interface.empty') }}"
               data-count="{{ __('interface.count') }}"
               data-error="{{ __('interface.error') }}">
        
        <p id="search-status" role="status" aria-live="polite" style="font-size: 0.9em; color: gray;"></p>
        <ul id="search-results"></ul>
    </div>

    <div class="terrains-grid">
        @forelse ($terrains as $terrain)
            <article>
                <h2><a href="{{ route('terrains.show', $terrain) }}">{{ $terrain->nom }}</a></h2>
                <p>{{ $terrain->type }} - {{ $terrain->adresse }}</p>
            </article>
        @empty
            <p>{{ __('interface.none') }}</p>
        @endforelse
    </div>
    
   {{ $terrains->links() }}
@endsection

@push('scripts')
    <script src="{{ asset('js/recherche.js') }}" defer></script>
@endpush