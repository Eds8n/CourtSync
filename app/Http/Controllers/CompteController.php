<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CompteController extends Controller
{
    public function show(Request $request): View
    {
        // Envoie l'utilisateur et seulement SES propres terrains à la vue
        return view('account.show', [
            'user' => $request->user(),
            'terrains' => $request->user()->terrains()->latest()->get(),
        ]);
    }
}