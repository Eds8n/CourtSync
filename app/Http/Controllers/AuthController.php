<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    // Affiche la page de connexion
    public function create(): View
    {
        return view('auth.login');
    }

    // Traite le formulaire de connexion
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Si les identifiants sont mauvais...
        if (! Auth::attempt($credentials)) {
            return back()
                ->withErrors(['email' => 'Identifiants invalides.'])
                ->onlyInput('email');
        }

        // Si c'est bon, on régénère la session pour la sécurité
        $request->session()->regenerate();
        
        return redirect()->intended(route('terrains.index'));
    }

    // Déconnecte l'utilisateur
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('terrains.index');
    }
}