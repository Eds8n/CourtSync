<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // On lit la langue dans la session, ou on prend celle par défaut
        $locale = $request->session()->get('locale', config('app.locale'));
        
        // On applique la langue (seulement si c'est 'fr' ou 'en')
        App::setLocale(in_array($locale, ['fr', 'en'], true) ? $locale : 'fr');
        
        return $next($request);
    }
}