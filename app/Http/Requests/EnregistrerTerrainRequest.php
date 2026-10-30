<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnregistrerTerrainRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
{
    return [
        'nom' => ['required', 'string', 'max:255'],
        'adresse' => ['required', 'string', 'max:255'],
        'type' => ['required', 'in:Interieur,Exterieur'],
        'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
    ];
}
}