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
            'nom' => ['required', 'string', 'max:100'],
            'adresse' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:50'],
        ];
    }
}