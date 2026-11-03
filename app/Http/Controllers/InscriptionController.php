<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Validation\ValidationException;


class InscriptionController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // 1. Validation des champs (sans le rôle, pour des raisons de sécurité)
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'confirmed', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // 2. Validation du jeton reCAPTCHA
        $token = $request->validate([
            'g-recaptcha-response' => ['required', 'string'],
        ])['g-recaptcha-response'];

        try {
            $verification = Http::asForm()->timeout(5)->post(
                'https://www.google.com/recaptcha/api/siteverify',
                [
                    'secret' => config('services.recaptcha.secret_key'),
                    'response' => $token,
                ]
            );
        } catch (ConnectionException $e) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => 'Vérification indisponible. Réessayez.',
            ]);
        }

        if (! $verification->successful() || $verification->json('success') !== true) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => 'Veuillez refaire la vérification.',
            ]);
        }

        // 3. Création du compte et connexion automatique
        $user = User::create($data);
        Auth::login($user);
        $request->session()->regenerate();

        // Redirection vers la liste des terrains
        return redirect()->route('terrains.index');
    }
}
